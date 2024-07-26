<template>
  <div>
    <div class="flex items-center p-4 border-b border-slate-900/10 lg:hidden dark:border-slate-50/[0.06]">
      <button type="button" class="text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300" @click="openLeftNav">
        <span class="sr-only">Navigation</span>
          <svg width="24" height="24">
          <path d="M5 6h14M5 12h14M5 18h14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
        </svg>
      </button>
    </div>
    <div class="w-full flex px-[--layout-gap] pb-[--layout-gap] lg:px-[--layout-gap-lg] lg:pb-[--layout-gap-lg]">
      {{VITE_PUSHER_APP_CLUSTER}}
      <div class="hidden lg:block inset-0 left-[max(0px,calc(50%-45rem))] right-auto w-[12rem] pb-10 pl-8 pr-6 overflow-y-auto">
        <nav id="nav" class="lg:text-sm lg:leading-6 relative">
          <ul>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 text-sky-500 dark:text-sky-400" href="/user">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                  </svg>
                </div>個人信息
              </a>
            </li>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 hover:text-slate-900" href="/user/vip">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                  <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                  </svg>
                </div>會員信息
              </a>
            </li>
            <li>
              <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 hover:text-slate-900" href="/orders">
                <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-indigo-200 dark:group-hover:bg-indigo-500 dark:bg-slate-800 dark:highlight-white/5"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                  <path d="m6 9 6-3 6 3v6l-6 3-6-3V9Z" class="fill-indigo-100 group-hover:fill-indigo-200 dark:fill-slate-400"></path>
                  <path d="m6 9 6 3v7l-6-3V9Z" class="fill-indigo-300 group-hover:fill-indigo-400 dark:group-hover:fill-indigo-300 dark:fill-slate-500"></path>
                  <path d="m18 9-6 3v7l6-3V9Z" class="fill-indigo-400 group-hover:fill-indigo-500 dark:group-hover:fill-indigo-400 dark:fill-slate-600"></path>
                </svg></div>個人訂單
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="lg:pl-[2.5rem] w-full">
        <div class="mx-auto xl:max-w-none xl:ml-0 xl:pr-16">
          <div class="relative">
            <div class="px-[--layout-gap] pb-[--layout-gap] lg:px-[--layout-gap-lg] lg:pb-[--layout-gap-lg]">
              <Card title="個人帳號信息">
                <form @submit.prevent="submit">
                  <div class="grid gap-x-4 gap-y-6 sm:grid-cols-2">
                    <ImageUpload
                      v-if="can.uploadAvatar"
                      id="avatar"
                      v-model="avataForm.avatar"
                      :loading="avataForm.processing"
                      :default-image="user.avatar ?? userPlaceholderSrc"
                      :removeable="!!user.avatar"
                      wrapper-class="text-center sm:col-span-2"
                      image-class="w-32 h-32 rounded-full mx-auto"
                      center-button
                      @selected="selectedAvatar"
                      @remove="removeAvatar"
                    />
                    <div v-else class="sm:col-span-2">
                      <img
                        :src="user.avatar ?? userPlaceholderSrc"
                        class="object-cover w-32 h-32 rounded-full mx-auto"
                      >
                    </div>
                    <TextInput id="name" v-model="form.name" label="姓名" />
                    <TextInput id="email" v-model="form.email" label="E-mail" type="email" />
                    <template v-if="!passwordLess">
                      <TextInput id="current_password" v-model="form.current_password" label="舊密碼" type="password" />
                      <div class="hidden sm:block" />
                      <TextInput id="password" v-model="form.password" label="新密碼" type="password" />
                      <TextInput id="password_confirmation" v-model="form.password_confirmation" label="確認密碼" type="password" />
                    </template>
                  </div>

                  <div class="mt-6">
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">
                      保存
                    </button>
                  </div>
                </form>
              </Card>

              <Card title="註銷帳號" class="mt-8">
                <button type="button" class="btn btn-danger" @click="deleteAccount">
                  註銷帳號
                </button>
              </Card>

              <CropImageModal
                v-model="showCropImageModal"
                title="剪裁頭像"
                :src="avatarPreviewSrc"
                :aspect-ratio="1 / 1"
                circle
                :loading="avataForm.processing"
                @cropped="croppedAvatar"
              />
            </div>
          </div>
          <footer class="text-sm leading-6 mt-12">
          </footer>
        </div>
      </div>
    </div>
    <TransitionRoot appear :show="isLeftNavOpen" as="template">
      <Dialog as="div" @close="closeLeftNav" class="fixed z-50 inset-0 overflow-y-auto lg:hidden">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/20 backdrop-blur-sm dark:bg-slate-900/80" />
        </TransitionChild>

        <div class="relative bg-blue-950/50 w-80 max-w-[calc(100%-3rem)] h-full p-6 dark:bg-slate-800">
          <button @click="closeLeftNav" type="button" class="absolute z-10 top-5 right-5 w-8 h-8 flex items-center justify-center text-slate-500 hover:text-slate-600 dark:text-slate-400 dark:hover:text-slate-300">
            <span class="sr-only">Close navigation</span>
            <BeakerIcon class="size-6 text-blue-500" />
            <svg viewBox="0 0 10 10" class="w-2.5 h-2.5 overflow-visible"><path d="M0 0L10 10M10 0L0 10" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>
          </button>
          <nav id="nav" class="lg:text-sm lg:leading-6 relative ">
            <ul>
              <li>
                <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 text-sky-500" href="/user">
                  <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                    </svg>
                  </div>個人信息
                </a>
              </li>
              <li>
                <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 hover:text-slate-900" href="/user/vip">
                  <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-sky-200 dark:group-hover:bg-sky-500 dark:bg-sky-500 dark:highlight-white/10">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-200 group-hover:fill-sky-500 dark:fill-sky-300 dark:group-hover:fill-sky-300"></path>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-400 group-hover:fill-sky-500 dark:fill-sky-200 dark:group-hover:fill-sky-200"></path>
                    </svg>
                  </div>會員信息
                </a>
              </li>
              <li>
                <a class="group flex items-center lg:text-sm lg:leading-6 mb-4 hover:text-slate-900" href="/orders">
                  <div class="mr-4 rounded-md ring-1 ring-slate-900/5 shadow-sm group-hover:shadow group-hover:ring-slate-900/10 dark:ring-0 dark:shadow-none dark:group-hover:shadow-none dark:group-hover:highlight-white/10 group-hover:shadow-indigo-200 dark:group-hover:bg-indigo-500 dark:bg-slate-800 dark:highlight-white/5"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                    <path d="m6 9 6-3 6 3v6l-6 3-6-3V9Z" class="fill-indigo-100 group-hover:fill-indigo-200 dark:fill-slate-400"></path>
                    <path d="m6 9 6 3v7l-6-3V9Z" class="fill-indigo-300 group-hover:fill-indigo-400 dark:group-hover:fill-indigo-300 dark:fill-slate-500"></path>
                    <path d="m18 9-6 3v7l6-3V9Z" class="fill-indigo-400 group-hover:fill-indigo-500 dark:group-hover:fill-indigo-400 dark:fill-slate-600"></path>
                  </svg></div>個人訂單
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>

</template>

<script setup lang="ts">
import userPlaceholderSrc from '@/images/user.svg'

defineOptions({ inheritAttrs: false })

const  VITE_PUSHER_APP_CLUSTER = import.meta.env.VITE_PUSHER_APP_CLUSTER;


const props = defineProps<{
  user: {
    id: string
    name: string
    email: string
    avatar: string | null
  }
  passwordLess: boolean
  can: {
    uploadAvatar: boolean
  }
}>()

const showCropImageModal = ref(false)

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  current_password: '',
  password: '',
  password_confirmation: '',
})

const avataForm = useForm({
  avatar: null as File | null,
})

const avatarPreviewSrc = ref<string | undefined>(undefined)

function submit() {
  form.put('/user/profile-information', {
    only: [...globalOnly, 'user', 'auth'],
    preserveScroll: true,
    onSuccess: () => form.reset('current_password', 'password', 'password_confirmation'),
    onError: () => form.reset('current_password', 'password', 'password_confirmation'),
  })
}

function selectedAvatar(file: File, dataUrl: string) {
  avataForm.avatar = null

  avatarPreviewSrc.value = dataUrl
  showCropImageModal.value = true
}

function croppedAvatar(blob: Blob) {
  avataForm.avatar = blob as any

  if (!props.can.uploadAvatar) return

  avataForm.post('/user/avatar', {
    only: [...globalOnly, 'user', 'auth'],
    preserveScroll: true,
    onSuccess: () => avataForm.reset('avatar'),
    onError: () => avataForm.reset('avatar'),
  })
}

function removeAvatar() {
  if (!props.can.uploadAvatar) return

  avataForm.delete('/user/avatar', {
    only: [...globalOnly, 'user', 'auth'],
    preserveScroll: true,
  })
}

function deleteAccount() {
  if (confirm('確定要刪除此帳號嗎? 此操作將無法恢復')) {
    router.get('/user/destroy/confirm')
  }
}

const isLeftNavOpen = ref(false)

function closeLeftNav() {
  isLeftNavOpen.value = false
}
function openLeftNav() {
  isLeftNavOpen.value = true
}
</script>
