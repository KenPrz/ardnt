<script setup>
import BoldIcon from 'vue-material-design-icons/FormatBold.vue';
import ItalicIcon from 'vue-material-design-icons/FormatItalic.vue';
import StrikethroughIcon from 'vue-material-design-icons/FormatStrikethrough.vue';
import ParagraphIcon from 'vue-material-design-icons/FormatParagraph.vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true
    },
    characterLimit: {
        type: Number,
        default: 140
    }
});
</script>
<template>
    <section v-if="editor" class="flex flex-wrap gap-2 py-2">
        <div class="control-group w-full">
            <div class="flex justify-between">
                <div class="button-group w-1/2">
                    <button @click="editor.chain().focus().toggleBold().run()"
                        :disabled="!editor.can().chain().focus().toggleBold().run()"
                        :class="{ 'bg-gray-200': editor.isActive('bold') }" class="btn">
                        <BoldIcon :size="20" title="Bold" />
                    </button>
                    <button @click="editor.chain().focus().toggleItalic().run()"
                        :disabled="!editor.can().chain().focus().toggleItalic().run()"
                        :class="{ 'bg-gray-200': editor.isActive('italic') }" class="btn">
                        <ItalicIcon :size="20" title="Italic" />
                    </button>
                    <button @click="editor.chain().focus().toggleStrike().run()"
                        :disabled="!editor.can().chain().focus().toggleStrike().run()"
                        :class="{ 'bg-gray-200': editor.isActive('strike') }" class="btn">
                        <StrikethroughIcon :size="20" title="Strikethrough" />
                    </button>
                    <button @click="editor.chain().focus().setParagraph().run()"
                        :class="{ 'bg-gray-200': editor.isActive('paragraph') }" class="btn">
                        <ParagraphIcon :size="20" title="Paragraph" />
                    </button>
                </div>
                <div class="w-1/2 flex justify-end">
                    <slot />
                </div>
            </div>
            <editor-content 
                :class="isMaxxed ? 'text-orange-500' : ''"
                :editor="editor" />
            <span :class="isMaxxed ? 'text-orange-500' : ''" class="font-light text-sm ms-1 mt-1">
                Character Limit: {{ editor.storage.characterCount.characters({ mode: 'nodeSize' }) - 4 }} / {{ limit - 4 }}
            </span>
        </div>
    </section>
</template>
<script>
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import CharacterCount from '@tiptap/extension-character-count'
export default {
    components: {
        EditorContent,
    },

    data() {
        return {
            editor: null,
            limit: 144,
            charsLeft: 0,
            isMaxxed: false,
        }
    },
    mounted() {
        this.editor = new Editor({
            content: this.modelValue,
            extensions: [
                StarterKit,
                CharacterCount.configure({
                    limit: this.limit,
                    mode: 'nodeSize',
                }),
            ],
            editorProps: {
                attributes: {
                    class:'border rounded-lg p-4 min-h-[5rem] max-h-[64rem] overflow-y-auto prose max-w-none focus:outline-none',
                },
            },
            onUpdate: ({ editor }) => {
                this.$emit('update:modelValue', editor.getHTML())
                this.updateCharacterCount()
            },
            beforeUnmount() {
                this.editor.destroy()
            },
        })
    },
    methods: {
        updateCharacterCount() {
            let calcData = this.editor.storage.characterCount.characters() - 4
            if(calcData == 140) {
                this.isMaxxed = true
            } else {
                this.isMaxxed = false
                this.charsLeft = calcData
            }
        },
    },
    beforeUnmount() {
        this.editor.destroy()
    },
}
</script>
<style scoped>
.btn {
    padding: .5rem;
    margin: .1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
}
</style>