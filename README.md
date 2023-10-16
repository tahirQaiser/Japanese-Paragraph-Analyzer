# Japanese Paragraph Analyzer

This tool analyzes Japanese paragraphs, breaking them into words or phrases and displaying their meanings.

## Usage

1. Input a Japanese paragraph into the provided textarea.

2. Click the "Analyze" button to process the input.

3. The tool will display the breakdown of the paragraph, with words/phrases and their meanings below the textarea.

## Technologies Used

- Laravel Framework (Version 10)
- Kuromoji for Japanese text tokenization
  - [Kuromoji Demo](https://www.atilika.org/kuromoji/)
  - [Kuromoji NPM Package](https://www.npmjs.com/package/kuromoji)
- Jisho API for retrieving word meanings/senses
  - [Jisho API](https://jisho.org/api/v1/search/words?keyword=<your%20word>)

## Features

1. Vocabulary Storage: Store vocabulary and its meanings/senses.

2. "Add to My Vocabulary" Button: Add words to the vocabulary table.

3. "Remove from My Vocabulary" Button: Remove words from the vocabulary table.

4. View My Vocabulary: View all words added to the table.

5. Random Word Display: Display a random word from "My Vocabulary."

