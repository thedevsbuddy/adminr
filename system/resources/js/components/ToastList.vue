<script setup>
  import toast from '../Composables/Toast'
</script>
<template>
  <TransitionGroup
      tag="div"
      enter-from-class="toasters-from"
      enter-active-class="toasters-active"
      leave-active-class="toasters-active"
      leave-to-class="toasters-from"
      class="toaster-container">
    <Toast v-for="(item, index) in toast.items" :item="item" :key="item?.key" :index="index" @remove="toast.remove(index)" />
  </TransitionGroup>
</template>

<style scoped>
.toaster-container {
  position: fixed;
  top: 1rem;
  right: 1rem;
  width: 100%;
  max-width: 300px;
  z-index: 9999 !important;
}
.toasters-from {
  transform: scale(.9) translateX(100%);
  opacity: 0;
}
.toasters-to {
  transform: scale(1) translateX(0);
  opacity: 1;
}
.toasters-active {
  transition: all 300ms ease-in-out;
}
</style>
