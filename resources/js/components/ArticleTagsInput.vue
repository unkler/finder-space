<template>
  <input
    type="hidden"
    name="tags"
    :value="tagsJson"
  >
  <vue3-tags-input
    :tags="tags"
    placeholder="タグを入力して下さい"
    @on-tags-changed="changedTags => tags = changedTags"
  />
</template>

<script>
  import { defineComponent } from 'vue';
  import Vue3TagsInput from 'vue3-tags-input';

  export default defineComponent({
  components: {
      Vue3TagsInput
  },
  props: {
    initialTags: {
      type: Array,
      default: [],
    },
  },
  data() {
      return {
          tags: this.initialTags
      }
  },
  computed: {
    tagsJson() {
      return JSON.stringify(this.tags)
    },
  }
})
</script>