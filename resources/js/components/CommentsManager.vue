<!-- TODO: connec to facebook/insta to choose a photo of the day and use this card https://tailwindcss.com/docs/examples/cards-->
<template>
    <div class="max-w-3xl mx-auto">

        <div class="mb-4 flex justify-center">
            <datetime v-model="date" id="datepicker" class="theme-blue"></datetime>
            <!-- calendar thing -->
            <!-- <div class="block rounded-t overflow-hidden bg-white text-center w-24 hover:bg-grey-lightest cursor-pointer hover:shadow-md hover:opacity-50">
                <div class="bg-red text-white py-1 cursor-pointer shadow-md">
                  	{{data.date.month}}
                </div>
                <div class="pt-1 border-l border-r">
                  	<span class="text-4xl font-bold">{{data.date.number}}</span>
                </div>
                <div class="pb-2 px-2 border-l border-r border-b rounded-b flex justify-between">
                  	<span class="text-xs font-bold">{{data.date.day}}</span>
                  	<span class="text-xs font-bold">{{data.date.year}}</span>
                </div>
                <datetime v-model="date"></datetime>
            </div> -->
            <!-- end calendar thing -->
        </div>
        <div class="bg-white rounded shadow-sm p-8 mb-4">
            <div class="mb-4">
                <h2 class="text-black">Entries</h2>
            </div>
            <textarea v-model="data.body"
                      placeholder="Add an entry"
                      class="bg-grey-lighter rounded leading-normal resize-none w-full py-2 px-3"
                      :class="[state === 'editing' ? 'h-24' : 'h-10']"
                      @focus="startEditing">
            </textarea>
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
        mounted() {
            var d = new Date();
            this.date = d.toISOString()
        },
        created() {
            this.fetchComments()
            //this.getDate()
        },
        data: function() {
            return {
                date: '',
                comments: [],
                data: {
                    body: ''
                },
                state: ''
          }
        },
        methods: {
            // updateComment($event) {
            //     console.log('working')
            //     let index = this.comments.findIndex((element) => {
            //         return element.id === $event.id;
            //     });
            //     this.comments[index].body = $event.body;
            // },
            // deleteComment($event) {
            //     let index = this.comments.findIndex((element) => {
            //         return element.id === $event.id;
            //     });
            //     this.comments.splice(index, 1);
            // },
            // saveComment() {
            //     let newComment = {
            //         id: this.comments[this.comments.length - 1].id + 1,
            //         body: this.data.body,
            //         edited: false,
            //         created_at: new Date().toLocaleString(),
            //         author: {
            //             id: this.user.id,
            //             name: this.user.name,
            //         }
            //     }
            //     this.comments.push(newComment);
            //
            //     this.data.body = '';
            // },
            // getDate() {
            //     var d = new Date();
            //     this.data.date.number = d.getDate()
            //     var day_num = d.getDay()
            //     this.data.date.day = this.getDayName(day_num)
            //     var month_num = d.getMonth()
            //     this.data.date.month = this.getMonthName(month_num)
            //     this.data.date.year = d.getFullYear()
            // },
            // getDayName(num) {
            //     var weekday = new Array(7)
            //     weekday[0] =  "Sun"
            //     weekday[1] = "Mon"
            //     weekday[2] = "Tues"
            //     weekday[3] = "Wed"
            //     weekday[4] = "Thurs"
            //     weekday[5] = "Fri"
            //     weekday[6] = "Sat"
            //     return weekday[num]
            // },
            // getMonthName(num) {
            //     var month = new Array()
            //     month[0] = "Jan"
            //     month[1] = "Feb"
            //     month[2] = "Mar"
            //     month[3] = "Apr"
            //     month[4] = "May"
            //     month[5] = "Jun"
            //     month[6] = "Jul"
            //     month[7] = "Aug"
            //     month[8] = "Sep"
            //     month[9] = "Oct"
            //     month[10] = "Nov"
            //     month[11] = "Dec"
            //     return month[num];
            // },
            startEditing() {
                this.state = 'editing';
            },
            stopEditing() {
                this.state = 'default';
                this.data.body = '';
            },
            fetchComments() {
                const t = this;
                axios.get('/comments').then(({data}) => {
                    t.comments = data;
                })
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
