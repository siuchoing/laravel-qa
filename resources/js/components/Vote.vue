<template>
    <div class="d-fex flex-column vote-controls">
        <a :title="title('up')"
           class="vote-up" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>

        <a :title="title('down')"
           class="vote-down" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name==='question'" :question="model"></favorite>
        <accept v-else :answer="model"></accept>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import Accept from './Accept.vue';

    export default {
        props: ['name', 'model'],
        component: {
            Favorite,
            Accept,
        },
        computed: {
            classes() {
                return this.signedIn ? '' : 'off';
            }
        },

        data () {
            return {
                count: this.model.votes_count
            }
        },

        methods: {
            title (voteType) {
                let titles = {
                    up: `This ${this.name} is useful`,
                    down: `This ${this.name} is not useful`,
                }
            }
        }

    }
</script>
