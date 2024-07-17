<template>
  <CardAuth title="注册">
    <form @submit.prevent="form.post('/register')">
      <div class="space-y-6">
        <TextInput id="name" v-model="form.name" label="姓名" />
        <TextInput id="email" v-model="form.email" label="E-mail" type="email" />
        <template v-if="!passwordLess">
          <TextInput id="password" v-model="form.password" label="密码" type="password" />
          <TextInput id="password_confirmation" v-model="form.password_confirmation" label="确认密码" type="password" />
        </template>
        <Field label="性别">
          <div class="mx-auto w-full max-w-md">
            <RadioGroup v-model="form.gender">
              <RadioGroupLabel class="sr-only">Server size</RadioGroupLabel>
              <div class="space-y-2">
                <RadioGroupOption as="template"
                  v-for="gender in gender_dicts"
                  :key="gender.value"
                  :value="gender.value"
                  v-slot="{ active, checked }"
                >
                  <div
                    :class="[ active ? 'ring-2 ring-white/60 ring-offset-2 ring-offset-sky-300' : '',checked ? 'bg-sky-900/75 text-white ' : 'bg-white ',]"
                    class="relative flex cursor-pointer rounded-lg px-5 py-4 shadow-md focus:outline-none"
                  >
                    <div class="flex w-full items-center justify-between">
                      <div class="flex items-center">
                        <div class="text-sm">
                          <RadioGroupLabel
                            as="p"
                            :class="checked ? 'text-white' : 'text-gray-900'"
                            class="font-medium"
                          >
                            {{ gender.label }}
                          </RadioGroupLabel>
                        </div>
                      </div>
                      <div v-show="checked" class="shrink-0 text-white">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                          <circle
                            cx="12"
                            cy="12"
                            r="12"
                            fill="#fff"
                            fill-opacity="0.2"
                          />
                          <path
                            d="M7 13l3 3 7-7"
                            stroke="#fff"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                          />
                        </svg>
                      </div>
                    </div>
                  </div>
                </RadioGroupOption>
              </div>
            </RadioGroup>
          </div>
        </Field>
      </div>

      <div class="mt-6">
        <button type="submit" class="btn btn-primary" :disabled="form.processing">
          注册
        </button>
      </div>
    </form>
  </CardAuth>
</template>

<script setup lang="ts">
defineOptions({ inheritAttrs: false })

defineProps<{
  passwordLess: boolean
}>()

const form = useForm({
  name: '',
  email: '',
  password: '',
  gender: 1,
  password_confirmation: '',
})

const gender_dicts = [
  {
    value: 1,
    label: '男',
  },
  {
    value: 2,
    label: '女',
  }
]

</script>
