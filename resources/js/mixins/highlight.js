import Prism from 'prismjs';

export default {
    methods: {
        hightlight () {
            const el = this.$refs.bodyHtml;
            if (el) Prism.highlightAllUnder(el);
        }
    }
}
