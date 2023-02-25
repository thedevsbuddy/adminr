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
      :class="`toaster-container ${toast.position}`">
    <Toast v-for="(item, index) in toast.items" :item="item" :key="item?.key" :index="index" @remove="toast.remove(index)" />
  </TransitionGroup>
</template>

<style lang="scss" scoped>
.toaster-container {
  position: fixed;
  width: 100%;
  max-width: 300px;
  z-index: 9999 !important;
}
.toaster-container.top-right {
  top: 1rem;
  right: 1rem;
}
.toaster-container.bottom-right {
  bottom: 1rem;
  right: 1rem;
}
.toaster-container.top-left {
  top: 1rem;
  left: 1rem;
}
.toaster-container.bottom-left {
  bottom: 1rem;
  left: 1rem;
}
.toaster-container.top-center {
  top: 1rem;
  left: 50%;
  transform: translateX(-50%);
}
.toaster-container.bottom-center {
  bottom: 1rem;
  left: 50%;
  transform: translateX(-50%);
}

.toasters-from {
  transform: scale(.9) translateX(100%);
  opacity: 0;
}
.toasters-to {
  transform: scale(1) translateX(0);
  opacity: 1;
}

/* Placements */
.top-left .toasters-from,
.bottom-left .toasters-from{
  transform: scale(.9) translateX(-100%);
}
.top-center .toasters-from{
  transform: scale(.9) translateY(-100%);
}
.bottom-center .toasters-from{
  transform: scale(.9) translateY(100%);
}
.top-center .toasters-to,
.bottom-center .toasters-to{
  transform: scale(1) translateY(0);
}

.toasters-active {
  transition: all 300ms ease-in-out;
}
</style>
