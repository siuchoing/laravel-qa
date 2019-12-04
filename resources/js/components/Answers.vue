<template>
    <div class="row mt-4" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <answer @deleted="remove(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>
                    <div class="text-center mt-3" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Answer from './Answer.vue';
    export default {
        props: ['question'],

        data () {
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextUrl: null
            }
        },


        methods: {
            remove (index) {
              this.answers.splice(index,1); // splice(start, deleteCount) method  changes the contents of an array by removing existing elements and/or adding new elements.
                this.count--;
            },
            fetch (endpoint) {
                axios.get(endpoint)
                    .then(( { data } ) => {
                        console.log( data );
                        this.answers.push( ...data.data );
                        this.nextUrl = data.next_page_url;
                    })
            }
        },
    created () {
        this.fetch(`/questions/${this.questionId}/answers`);
    },

        computed: {
            title () {
                return this.count + ' ' + (this.count > 1 ? 'Answers' : 'Answer');
            }
        },

        components: { Answer },

    }
</script>
