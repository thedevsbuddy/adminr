<template>
  <svg>
    <use :xlink:href="adminrIcon(`cil-${props.name}`)"></use>
  </svg>
</template>

<script setup>
const props = defineProps({
  name: String,
})
</script>
