<template>
    <img class="rounded-full" :src="avatar">
</template>

<script setup lang="ts">

import defaultMan from '@/images/man.svg';
import defaultWomen from '@/images/women.svg';
const props = defineProps<{
  gender?: number| null,
  src?: string | null,
}>()

const avatar = computed(() => {
  if (props.src) {
    return props.src;
  } else{
    if(props.gender == 2) {
      return defaultWomen;
    }else{
      return defaultMan;
    }
  }
})

</script>
