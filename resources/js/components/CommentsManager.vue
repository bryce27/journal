<!-- TODO: connec to facebook/insta to choose a photo of the day and use this card https://tailwindcss.com/docs/examples/cards-->
<template>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 mt-4 flex justify-center">
            <a id="todaylink" class="no-underline mr-5" href="#" @click.prevent="date = todays_date" v-if="todays_date != date">Go to Today</a>
            <datetime v-model="date" id="datepicker" class="theme-blue" value-zone="America/Denver" :format="{ year: 'numeric', month: 'long', day: 'numeric'}"></datetime>
        </div>
        <div class="bg-white rounded shadow-sm p-8 mb-4" v-if="todays_date == date">
            <div class="mb-4">
                <h2 class="text-black">Entries</h2>
            </div>
            <textarea v-model="data.body"
                      placeholder="Add an entry"
                      class="bg-grey-lighter rounded leading-normal resize-none w-full py-2 px-3"
                      :class="[state === 'editing' ? 'h-24' : 'h-10']"
                      @focus="startEditing">
            </textarea>
            <!-- add google photo integration -->
            <textarea v-model="data.video_url"
                      v-if="state == 'editing'"
                      placeholder="Add a video link"
                      class="bg-grey-lighter rounded leading-normal resize-none w-full py-2 px-3 h-10 mt-2"
                      @focus="startEditing">
            </textarea>
            <!-- select song from spotify or image from social media or tag from previous tags or new tag -->
            <div v-show="state === 'editing'" class="mt-3">
                <button class="border border-blue bg-blue text-white hover:bg-blue-dark py-2 px-4 rounded tracking-wide mr-1" @click="saveComment">Save</button>
                <button class="border border-grey-darker text-grey-darker hover:bg-grey-dark hover:text-white py-2 px-4 rounded tracking-wide ml-1" @click="stopEditing">Cancel</button>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm p-8">
            <comment v-for="(comment, index) in comments"
                     :key="comment.id"
                     :user="user"
                     :comment="comment"
                     :class="[index === comments.length - 1 ? '' : 'mb-6']"
                     @comment-updated="updateComment($event)"
                     @comment-deleted="deleteComment($event)">
            </comment>
            <p v-if="comments.length == 0 && !loading">There are no entries for this day.</p>
        </div>
    </div>
</template>
<script>
    import comment from './CommentItem'
    export default {
        props: {
            user: {
                required: true,
                type: Object,
            }
        },
        components: {
            comment
        },
        created() {
            var d = new Date()
            this.date = d.toISOString()
        },
        data: function() {
            return {
                date: '',
                todays_date: '',
                comments: [],
                data: {
                    body: '',
                    video_url: '',
                },
                state: '',
                loading: true
          }
        },
        watch: {
            date: function(new_val, old_val){
                const t = this
                if (new_val !== old_val){
                    if (this.todays_date == ''){
                        this.todays_date = new_val
                    }
                    this.fetchComments(new_val)
                }
            }
        },
        methods: {
            startEditing() {
                this.state = 'editing';
            },
            stopEditing() {
                this.state = 'default';
                this.data.body = '';
            },
            fetchComments(date = null) {
                const t = this
                t.loading = true
                if (date){ // filter for that day
                    t.comments = []
                    axios.get('/comments/'+date).then(({data}) => {
                        t.comments = data;
                        t.loading = false
                    })
                }
                else {
                    axios.get('/comments').then(({data}) => {
                        t.comments = data;
                        t.loading = false
                    })
                }

            },
            saveComment() {
                const t = this;
                axios.post('/comments', t.data).then(({data}) => {
                    t.comments.unshift(data);
                    t.stopEditing();
                })
            },
            updateComment($event) {
                const t = this;
                axios.put(`/comments/${$event.id}`, $event).then(({data}) => {
                    t.comments[t.commentIndex($event.id)].body = data.body;
                })
            },
            deleteComment($event) {
                const t = this;
                axios.delete(`/comments/${$event.id}`, $event).then(() => {
                    t.comments.splice(t.commentIndex($event.id), 1);
                })
            },
            commentIndex(commentId) {
                return this.comments.findIndex((element) => {
                    return element.id === commentId;
                });
            }

        }
    }
</script>
