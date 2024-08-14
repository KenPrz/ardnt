<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import BoldIcon from 'vue-material-design-icons/FormatBold.vue';
import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue';
import StrikethroughIcon  from 'vue-material-design-icons/FormatStrikethrough.vue';
import ParagraphIcon from 'vue-material-design-icons/FormatParagraph.vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['update:modelValue'])
const editor = useEditor({
    content: props.modelValue,
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML())
    },
    editorProps: {
        attributes: {
            class: 'border rounded-lg p-4 min-h-[5rem] max-h-[64rem] overflow-y-auto prose max-w-none focus:outline-none',
        },
    },
    extensions: [StarterKit],
})
</script>
<template>
    <section v-if="editor" class="flex flex-wrap gap-2 py-2">
        <div class="control-group w-full">
            <div class="flex justify-between">
                <div class="button-group w-1/2">
                    <button @click="editor.chain().focus().toggleBold().run()"
                        :disabled="!editor.can().chain().focus().toggleBold().run()"
                        :class="{ 'bg-gray-200': editor.isActive('bold') }"
                        class="btn">
                        <BoldIcon :size="20" title="Bold"/>
                    </button>
                    <button @click="editor.chain().focus().toggleItalic().run()"
                        :disabled="!editor.can().chain().focus().toggleItalic().run()"
                        :class="{ 'bg-gray-200': editor.isActive('italic') }"
                        class="btn">
                        <ItalicIcon :size="20" title="Italic"/>
                    </button>
                    <button @click="editor.chain().focus().toggleStrike().run()"
                        :disabled="!editor.can().chain().focus().toggleStrike().run()"
                        :class="{ 'bg-gray-200': editor.isActive('strike') }"
                        class="btn">
                        <StrikethroughIcon :size="20" title="Strikethrough"/>
                    </button>
                    <button @click="editor.chain().focus().setParagraph().run()"
                        :class="{ 'bg-gray-200': editor.isActive('paragraph') }"
                        class="btn">
                        <ParagraphIcon :size="20" title="Paragraph"/>
                    </button>
                </div>
                <div class="w-1/2 flex justify-end">
                    <slot />
                </div>
            </div>
            <editor-content class :editor="editor" />
        </div>
    </section>
    <EditorContent :editor="editor" />
</template>

<style scoped>
.btn {
    padding:.5rem;
    margin: .1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
}
</style>