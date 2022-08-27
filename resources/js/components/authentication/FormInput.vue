<template>
    <o-field :label="label">
        <o-input :class="{'is-danger' : errorCondition}" :value="modelValue"
                 @input="$emit('update:modelValue', $event.target.value)" :type="type" required
                 :placeholder="placeholder"
                 :password-reveal="passwordReveal !== undefined"></o-input>
    </o-field>
</template>

<script>
export default {
    props: ['label', 'placeholder', 'type', 'modelValue', 'errorCondition', 'passwordReveal'],
    name: "FormInput"
}
</script>

<style scoped>

</style>
