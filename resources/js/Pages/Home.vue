<template>
    <div class="app-container mt-5">
        <div class="d-flex justify-content-between">
            <h3>Home</h3>
            <div>
                <Link class="text-decoration-none me-3" href="/my-vocabulary">My Vocabulary</Link>
                <Link class="text-decoration-none" href="/vocabularies">Vocabularies</Link>
            </div>
        </div>
        <form @submit.prevent="tokenize">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Enter Japanese text below</label>
                <textarea class="form-control" v-model="japaneseText"></textarea>
                <div v-if="error" class="form-text text-danger">{{ error }}</div>
            </div>

            <button type="submit" class="btn btn-sm btn-dark" :disabled="processing">Submit</button>
            <!-- Show loading on while processing -->
            <svg v-if="processing" style="width: 50px; height: 50px;" xmlns="http://www.w3.org/2000/svg"
                 x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#333"
                      d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                  <animateTransform
                      attributeName="transform"
                      attributeType="XML"
                      type="rotate"
                      dur="1s"
                      from="0 50 50"
                      to="360 50 50"
                      repeatCount="indefinite"/>
              </path>
            </svg>
        </form>

        <table class="table table-sm table-bordered table-hover table-striped my-3" v-if="tokens.length">
            <thead>
            <tr>
                <th>Word</th>
                <th>Meaning</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(token,index) in tokens" :key="index">
                <td class="w-25">{{ token.word }}</td>
                <td>{{ token.meaning.join(', ') }}</td>
                <td>
                    <label v-if="token.vocabulary" class="badge btn btn-danger" @click="updateVocabulary(index)">Remove
                        from vocabulary</label>
                    <label v-else class="badge btn btn-dark" @click="updateVocabulary(index)">Add to
                        vocabulary</label>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import {ref} from "vue";
import kuromoji from "kuromoji";

const error = ref('');
const tokens = ref([]);
const japaneseText = ref('');
const processing = ref(false);

const tokenize = () => {
    error.value = '';
    tokens.value = [];
    if (japaneseText.value === '') {
        error.value = 'Japanese text field is required'
    }
    processing.value = true;
    kuromoji.builder({dicPath: null}).build(function (err, tokenizer) {
        /*if (error != null) {
            console.log(error);
        }*/
        // tokenizer is ready
        let japaneseTokens = tokenizer.tokenize(japaneseText.value);
        if (japaneseTokens) {
            let surface_form_words = japaneseTokens.map(token => {
                return token.surface_form
            });

            axios.post('process-words/', {words: surface_form_words}).then((response) => {
                if (response.data.success) {
                    tokens.value = response.data.processed_words;
                }
                processing.value = false;
            });
        }
    });
}

const updateVocabulary = (index) => {
    processing.value = true;
    if (!tokens.value[index].vocabulary) {
        // Add Vocabulary
        axios.post('vocabularies', tokens.value[index]).then((response) => {
            if (response.data.success) {
                tokens.value[index].vocabulary = response.data.vocabulary;
            }
            processing.value = false;
        }).catch(function (error_response) {
            if (error_response.response.data) {
                error.value = error_response.response.data.message;
            }
            processing.value = false;
        });
    } else {
        // Remove Vocabulary
        axios.delete(`vocabularies/${tokens.value[index].vocabulary}`).then((response) => {
            if (response.data.success) {
                tokens.value[index].vocabulary = 0;
            }
            processing.value = false;
        }).catch(function (error_response) {
            if (error_response.response.data) {
                error.value = error_response.response.data.message;
            }
            processing.value = false;
        });
    }
}

</script>

<style scoped>
.app-container {
    margin: auto;
    max-width: 700px;
}
</style>