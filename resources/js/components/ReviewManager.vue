<!-- TODO: connec to facebook/insta to choose a photo of the day and use this card https://tailwindcss.com/docs/examples/cards-->
<template>
    <div class="max-w-3xl mx-auto">
        <div class="mb-4 flex justify-center">
            <div class="mr-2 mb-6 mt-4">
                <div class="inline-block relative w-60 text-xl font-bold">
                      <select disabled v-model="year_selected" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
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
                      <select v-model="month_selected" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option disabled value="">Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                      </select>
                      <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                      </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap bg-white rounded shadow-sm p-8">

            <div class="lg:flex p-2 m-2 flex-1 cursor-pointer hover:shadow-md border-r border-b border-grey-light" v-for="(comment, index) in comments"
                :key="comment.id" :user="user" :comment="comment">
              <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" style="background-image: url('https://tailwindcss.com/img/card-left.jpg')" title="Woman holding a mug">
              </div>
              <div class="bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                  <div class="text-black font-bold text-xl mb-2">{{comment.created_at | moment("dddd Do")}}</div>
                  <p class="text-grey-darker text-base">{{comment.body}}</p>
                </div>
              </div>
            </div>
            <p v-if="comments.length == 0 && !loading">There are no entries for this month.</p>
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
                loading: true,
                month_selected: '',
                year_selected: '2018'
          }
        },
        watch: {
            // date: function(new_val, old_val){
            //     const t = this
            //     if (new_val !== old_val){
            //         if (this.todays_date == ''){
            //             this.todays_date = new_val
            //         }
            //         this.fetchComments(new_val)
            //     }
            // },
            month_selected: function(new_val, old_val){
                this.fetchComments(new_val)
            }
        },
        methods: {
            fetchComments(month = null) {
                const t = this
                t.loading = true
                if (month){ // filter for that day
                    t.comments = []
                    axios.get('/comments/month/'+month).then(({data}) => {
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
