<template>
    <div>
        <span class="text-muted">{{ postDate }}</span>
        <div class="media mt-2">
            <a :href="user.url" class="pr-2">
                <img :src="user.avatar" style="width: 33px;">
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{ user.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['model', 'label'],          // <user-info model="..." label=""></user-info>

        computed: {                         // everything defined as a key, and only computed when something has changed
            postDate () {
                return this.label + " " + this.model.created_date;
            }
        },

        data () {
            return {
                user: this.model.user
            }
        }
    }
</script>
