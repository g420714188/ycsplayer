<template>
  <CardAuth :title="room.name">
    <form @submit.prevent="form.post(`/rooms/${room.id}/joinByInviteCode`)">
      <Message v-if="status" :content="status" class="mb-4" />
      <TextInput id="id" v-model="form.id" label="房間号" type="text" wrapperClass="hidden" />
      <div class="space-y-6">
        <TextInput id="invite_code" v-model="form.invite_code" label="邀请码" type="text" />
      </div>

      <div class="mt-6 flex justify-between items-center">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          {{ '加入' }}
        </button>
      </div>
    </form>
  </CardAuth>
</template>

<script setup lang="ts">
import {Room} from "@/types";

defineOptions({ inheritAttrs: false })

const props = defineProps<{
  room: Room | null,
  invite_code: string | null
}>()

const form = useForm({
  id: props.room.id,
  invite_code: ''
})
</script>
