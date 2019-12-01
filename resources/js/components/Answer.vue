<template>

</template>

<script>
    export default {
        props: ['answer'],
        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null,
            }
        },

        methods: {
            edit () {
                // store value before edit
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel () {
                this.body = this.beforeEditCache;
                this.editing = false;
            },

            // php artisan route:list --name="questions.answers.update"
            // you will get URL: questions/{question}/answers/{answer}
            update() {
                console.log('123');
                axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                })
                .then(res => {      // return reponseObject
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    alert(res.data.message)
                })
                .catch(err => {
                    // console.log(error.response.data.errors.body[0]);
                    alert(err.response.data.message);
                });
            },
        },

        computed: {
            isInvalid () {
                return this.body.length < 10;
            }
        }
    }

</script>

<style scoped>

</style>
