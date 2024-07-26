<template>
  <Modal
    v-model="show"
    title="創建房間"
    max-width-class="max-w-[560px] w-full"
  >
    <template #icon>
      <HeroiconsPlayCircle class="mr-1" />
    </template>

    <div class="mt-4 relative">
      <form @submit.prevent="form.post('/rooms')">
        <div class="space-y-6">
          <TextInput id="name" v-model="form.name" label="房間名稱" />
          <RoomTypeSelectField id="type" v-model="form.type" />
          <!-- vip权限 -->
          <TextInput id="invite_code" v-model="form.invite_code" label="加入码" tip="会员享有" :disabled="isVip" />
          <SwitchField id="auto_play" v-model="form.auto_play" label="連續播放" />
          <SwitchField id="auto_remove" v-model="form.auto_remove" label="播放完畢自動刪除" />
        </div>
        <div class="mt-6">
          <button type="submit" class="btn btn-primary" :disabled="form.processing">
            保存{{page.props?.flash?.error}}
          </button>
        </div>
      </form>
    </div>
  </Modal>
</template>

<script setup lang="ts">
import {PlayerTrigger, RoomType} from '@/types'
import {usePage} from "@inertiajs/vue3";

const show = defineModel<boolean>({ required: true })

// 人数限制 0表示不限制

const form = useForm({
  name: '',
  type: RoomType.Video,
  limit_number: 0,
  auto_play: false,
  auto_remove: false,
})
const page = usePage();

watch(() => form.type, () => {
  if (form.type === RoomType.Video) {
    form.auto_play = false
    form.auto_remove = false
  } else if (form.type === RoomType.Audio) {
    form.auto_play = true
    form.auto_remove = false
  }
}, { immediate: true })

const isVip = computed(() => {
  return !false;
})

</script>
