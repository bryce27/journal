<template>
    <div class="max-w-2xl mx-auto flex">
        <div class="bg-white rounded shadow-sm p-8 pb-0 mb-4 mr-4 flex-1" >
            <div class="mb-4">
                <h2 class="text-black hover:text-blue no-underline">{{this.comment.created_at | moment("MMMM Do YYYY")}}</h2>
            </div>
            <div class="mt-6">
                <p>{{data.body}}</p>
            </div>
            <div class="py-5 mt-5">
                <span v-on:click="" class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2 hover:bg-grey-light cursor-pointer">#photography</span>
                <span v-on:click="" class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2 hover:bg-grey-light cursor-pointer">#travel</span>
                <span v-on:click="" class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker hover:bg-grey-light cursor-pointer">#winter</span>
            </div>
        </div>
        <div class="bg-white rounded shadow-sm p-8 mb-4 ml-4 flex-1" >
            <div class="mb-4">
                <h2 class="text-black">Cool Stuff</h2>
            </div>
            <div class="mt-3">
                <p>Weather</p>
                <p>Spotify</p>
                <p>Pictures</p>
                <p>Trends</p>
                <p>Emotional / Textual Analysis</p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['user', 'comment'],
        data: function() {
            return {
                data: {
                    body: this.comment.body,
                }
          }
        },
        methods: {
            deleteComment() {
                this.$emit('comment-deleted', {
                    'id': this.comment.id,
                });
            }
        }
    }
</script>
