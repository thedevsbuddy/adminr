<script setup>
import {computed, onMounted} from "vue";

const props = defineProps({
  item: Object,
  index: Number,
})
const emit = defineEmits(['remove']);

onMounted(() => {
  setTimeout(function () {
    if(props.item.autoHide){
      emit('remove');
    }
  }, props.item.duration);
});


</script>
<template>
  <div :class="`toaster-item ${props.item.type}`" role="alert">
    <div class="icon" v-if="props.item.hasIcon">
      <svg v-if="props.item.type === 'warning'" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
           stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
      </svg>
      <svg v-if="props.item.type === 'info'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
      </svg>
      <svg v-if="props.item.type === 'success'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
      </svg>
      <svg v-if="props.item.type === 'danger'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/>
      </svg>
    </div>
    <div class="message">{{ item.message }}</div>
    <button type="button" v-if="props.item.canClose" @click.stop="emit('remove')" class="" data-dismiss-target="#toast-default" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
      </svg>
    </button>
  </div>
</template>

<style lang="scss" scoped>
.toaster-item {
  --success-color: #1e8d1e;
  --success-bg-color: #e9ffe9;
  --info-color: #4d61ff;
  --info-bg-color: #e9ecff;
  --warning-color: #d6a41a;
  --warning-bg-color: #fff9e9;
  --danger-color: #ff4040;
  --danger-bg-color: #ffe9e9;
  --fg-color: var(--info-color);
  --bg-color: var(--info-bg-color);

  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
  padding: .5rem;
  background: white;
  color: #373737;
  border-radius: .5rem;
  box-shadow: 0 4px 5px 0 rgba(0, 0, 0, .15), -1px -1px 5px 0 rgba(0, 0, 0, .1);
  margin-bottom: .5rem;

  &.success {
    --fg-color: var(--success-color);
    --bg-color: var(--success-bg-color);
  }

  &.info {
    --fg-color: var(--info-color);
    --bg-color: var(--info-bg-color);
  }

  &.warning {
    --fg-color: var(--warning-color);
    --bg-color: var(--warning-bg-color);
  }

  &.danger {
    --fg-color: var(--danger-color);
    --bg-color: var(--danger-bg-color);
  }

  &.default {
    --fg-color: #fff;
    --bg-color: #161927;
    background: #27293a;
    color: #fff;
  }

  .icon {
    padding: .5rem;
    border-radius: .5rem;
    background: var(--bg-color);
    color: var(--fg-color);
    display: inline-block;
  }

  .message {
    font-size: .875rem;
    font-weight: normal;
    margin-inline: .5rem;
    color: var(--fg-color);
  }

  button {
    all: unset;
    width: 1rem;
    height: 1rem;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: .5rem;
    margin-left: auto;
    cursor: pointer;
    border-radius: .5rem;
    color: #333333;
    transition: color 250ms ease,background 250ms ease;

    &:hover {
      background: var(--bg-color);
      color: var(--fg-color);
    }
  }
}


.w-5 {
  width: 1.25rem;
}

.h-5 {
  height: 1.25rem;
}

.w-4 {
  width: 1rem;
}

.h-4 {
  height: 1rem;
}

</style>
