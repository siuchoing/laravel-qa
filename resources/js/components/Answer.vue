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
                axios.patch(this.endpoint, {
                    body: this.body
                })
                .then(res => {      // return reponseObject
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    //alert('sad');
                    this.$toast.success(res.data.message, "Success", { timeout: 3000 });
                })
                .catch(err => {
                    // console.log(error.response.data.errors.body[0]);
                    this.$toast.error(err.response.data.message, "Error", { timeout: 3000 });
                    //alert(err.response.data.message);
                });
            },

            destroy () {
                if (confirm('Are you sure?')) {
                    axios.delete(this.endpoint)
                        .then(res => {
                            // fadeOut($running_time, $action_after_running)
                            $(this.$el).fadeOut(500, () =>{
                                this.$toast.error(res.data.message, "Success", { timeout: 3000 });
                            })
                        })
                }

            }
        },

        computed: {
            isInvalid () {
                return this.body.length < 10;
            },

            endpoint () {
                return `/questions/${this.questionId}/answers/${this.id}`;
            },
        }
    }

</script>
