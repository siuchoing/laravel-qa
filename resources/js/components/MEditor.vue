<template>
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#write">Write</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#preview">Preview</a>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content">
            <div class="tab-pane active" id="write"> <!-- id need to be same as href -->
                <slot></slot>   <!-- Parent component to child component -->
            </div>
            <div class="tab-pane" v-html="preview" id="preview"></div>
        </div>
    </div>
</template>

<script>
    import MarkdownIt from 'markdown-it';
    const md = new MarkdownIt();

    export default {
        props: ['body'],

        computed: {
            // render raw markdown into html, and then pass the body in
            preview () {
                return md.render(this.body);
            }
        },

        watch: {
            body () {
                console.log('watch body');
                // from a NodeList
                //autosize(document.querySelectorAll('textarea'));
            }
        },

        // This updated life cycle hook executed after data changes in our component and a DOM re-render
        updated () {
            console.log('updated hook');
        }
    }
</script>
