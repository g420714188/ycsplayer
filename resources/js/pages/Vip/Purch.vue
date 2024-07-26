<template>
  <div class="bg-white py-24 sm:py-32">
   {{html_text}}
  </div>
</template>

<script setup lang="ts">
// import { CheckIcon } from '@heroicons/vue/20/solid'

const includedFeatures = [
  'Private forum access',
  'Member resources',
  'Entry to annual conference',
  'Official member t-shirt',
]
const form = useForm({
})
const props = defineProps<{
  html_text: string
}>()
</script>
