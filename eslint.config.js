export default ycs77({
  vue: true,
  typescript: true,
  ignores: [
    'composer.json',
    'tsconfig.json',
    'lang/**/*',
  ],
}).append({
    files: [GLOB_TS, GLOB_VUE],
    rules: {
      'no-alert': 'off',
      'no-console': 'off',

      'antfu/curly': 'off',

      'ts/prefer-ts-expect-error': 'off',
    },
  })
