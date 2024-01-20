module.exports = {
    env: {
        node: true,
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
    "plugins": ["prettier"],
    rules: {
        "prettier/prettier": "error",
        indent: ["error", 4],
        "linebreak-style": ["error", "unix"],
        quotes: ["error", "single"],
        semi: ["error", "never"],
        "vue/multi-word-component-names": "off",
    },
    globals: {
        __: "readonly",
        route: "readonly",
        axios: "readonly",
        recaptcha: "readonly",
        document: "readonly",
        window: "readonly",
    },
};
