<!-- TODO: connec to facebook/insta to choose a photo of the day and use this card https://tailwindcss.com/docs/examples/cards-->
<template>
    <div class="max-w-3xl mx-auto">
        <div class="mb-4 flex justify-center">
            <div class="mr-2 mb-6 mt-4">
                <div class="inline-block relative w-60 text-xl font-bold">
                      <select class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option>2018</option>
                        <!-- <option>2019</option> -->
                      </select>
                      <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                      </div>
                </div>
            </div>
            <div class="ml-2 mb-6 mt-4">
                <div class="inline-block relative w-60 text-xl font-bold">
                      <select class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>Sept</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                      </select>
                      <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                      </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap bg-white rounded shadow-sm p-8">

            <div class="lg:flex p-2 shadow-sm flex-1 hover:bg-grey-lightest cursor-pointer" v-for="(comment, index) in comments"
                :key="comment.id" :user="user" :comment="comment">
              <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('https://tailwindcss.com/img/card-left.jpg')" title="Woman holding a mug">
              </div>
              <div class="border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                  <div class="text-black font-bold text-xl mb-2">{{comment.created_at}}</div>
                  <p class="text-grey-darker text-base">{{comment.body}}</p>
                </div>
              </div>
            </div>

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
                    body: ''
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
