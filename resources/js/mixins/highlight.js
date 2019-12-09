import Prism from 'prismjs';

export default {
    methods: {
        hightlight () {
            const el = this.$refs.bodyHtml;
            console.log('el', el);
            if (el) Prism.highlightAllUnder(el);
        }
    }
}
