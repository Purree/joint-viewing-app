<template>
    <o-field :label="label">
        <o-input :class="errorCondition ? 'is-danger' : ''" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" :type="type" required
                 :placeholder="placeholder"></o-input>
    </o-field>
</template>

<script>
export default {
    props: ['label', 'placeholder', 'type', 'modelValue', 'errorCondition'],
    name: "FormInput"
}
</script>

<style scoped>

</style>
