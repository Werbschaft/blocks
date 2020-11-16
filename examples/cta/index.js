panel.plugin("getkirby/cta", {
    components: {
        "k-block-type-cta": {
            props: {
                content: Object
            },
            template: `
                <button type="button" class="k-block-type-cta-button" @click="$emit('open')">{{ content .text }}</button>
            `
        }
    }
});
