<?php

    class Permalink
    {
        /**
         * Transliterate a UTF-8 value to ASCII.
         *
         * @param  string  $value
         * @param  string  $language
         * @return string
         */
        public static function ascii($value, $language = 'en')
        {
            $languageSpecific = static::languageSpecificCharsArray($language);

            if (! is_null($languageSpecific)) {
                $value = str_replace($languageSpecific[0], $languageSpecific[1], $value);
            }

            foreach (static::charsArray() as $key => $val) {
                $value = str_replace($val, $key, $value);
            }

            return preg_replace('/[^\x20-\x7E]/u', '', $value);
        }

        /**
         * Generate a URL friendly "slug" from a given string.
         *
         * @param  string  $text
         * @param  string  $separator
         * @param  string  $language
         * @return string
         */
        public static function generate($text, $separator = '-', $language = 'en')
        {
            $text = static::ascii($text, $language);

            // Convert all dashes/underscores into separator
            $flip = $separator == '-' ? '_' : '-';

            $text = preg_replace('!['.preg_quote($flip).']+!u', $separator, $text);

            // Replace @ with the word 'at'
            $text = str_replace('@', $separator.'at'.$separator, $text);

            // Remove all characters that are not the separator, letters, numbers, or whitespace.
            $text = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($text));

            // Replace all separator characters and whitespace by a single separator
            $text = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $text);

            return trim($text, $separator);
        }

        /**
         * Returns the replacements for the ascii method.
         *
         * Note: Adapted from Stringy\Stringy.
         *
         * @see https://github.com/danielstjules/Stringy/blob/3.1.0/LICENSE.txt
         *
         * @return array
         */
        protected static function charsArray()
        {
            static $charsArray;

            if (isset($charsArray)) {
                return $charsArray;
            }

            return $charsArray = array(
                '0'    => array('°', '₀', '۰', '０'),
                '1'    => array('¹', '₁', '۱', '１'),
                '2'    => array('²', '₂', '۲', '２'),
                '3'    => array('³', '₃', '۳', '３'),
                '4'    => array('⁴', '₄', '۴', '٤', '４'),
                '5'    => array('⁵', '₅', '۵', '٥', '５'),
                '6'    => array('⁶', '₆', '۶', '٦', '６'),
                '7'    => array('⁷', '₇', '۷', '７'),
                '8'    => array('⁸', '₈', '۸', '８'),
                '9'    => array('⁹', '₉', '۹', '９'),
                'a'    => array('à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا', 'ａ', 'ä'),
                'b'    => array('б', 'β', 'ب', 'ဗ', 'ბ', 'ｂ'),
                'c'    => array('ç', 'ć', 'č', 'ĉ', 'ċ', 'ｃ'),
                'd'    => array('ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ', 'ｄ'),
                'e'    => array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ', 'ｅ'),
                'f'    => array('ф', 'φ', 'ف', 'ƒ', 'ფ', 'ｆ'),
                'g'    => array('ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ', 'ｇ'),
                'h'    => array('ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ', 'ｈ'),
                'i'    => array('í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ', 'ی', 'ｉ'),
                'j'    => array('ĵ', 'ј', 'Ј', 'ჯ', 'ج', 'ｊ'),
                'k'    => array('ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک', 'ｋ'),
                'l'    => array('ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ', 'ｌ'),
                'm'    => array('м', 'μ', 'م', 'မ', 'მ', 'ｍ'),
                'n'    => array('ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ', 'ｎ'),
                'o'    => array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ', 'ｏ', 'ö'),
                'p'    => array('п', 'π', 'ပ', 'პ', 'پ', 'ｐ'),
                'q'    => array('ყ', 'ｑ'),
                'r'    => array('ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ', 'ｒ'),
                's'    => array('ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს', 'ｓ'),
                't'    => array('ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ', 'ｔ'),
                'u'    => array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ', 'ｕ', 'ў', 'ü'),
                'v'    => array('в', 'ვ', 'ϐ', 'ｖ'),
                'w'    => array('ŵ', 'ω', 'ώ', 'ဝ', 'ွ', 'ｗ'),
                'x'    => array('χ', 'ξ', 'ｘ'),
                'y'    => array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ', 'ｙ'),
                'z'    => array('ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ', 'ｚ'),
                'aa'   => array('ع', 'आ', 'آ'),
                'ae'   => array('æ', 'ǽ'),
                'ai'   => array('ऐ'),
                'ch'   => array('ч', 'ჩ', 'ჭ', 'چ'),
                'dj'   => array('ђ', 'đ'),
                'dz'   => array('џ', 'ძ'),
                'ei'   => array('ऍ'),
                'gh'   => array('غ', 'ღ'),
                'ii'   => array('ई'),
                'ij'   => array('ĳ'),
                'kh'   => array('х', 'خ', 'ხ'),
                'lj'   => array('љ'),
                'nj'   => array('њ'),
                'oe'   => array('ö', 'œ', 'ؤ'),
                'oi'   => array('ऑ'),
                'oii'  => array('ऒ'),
                'ps'   => array('ψ'),
                'sh'   => array('ш', 'შ', 'ش'),
                'shch' => array('щ'),
                'ss'   => array('ß'),
                'sx'   => array('ŝ'),
                'th'   => array('þ', 'ϑ', 'ث', 'ذ', 'ظ'),
                'ts'   => array('ц', 'ც', 'წ'),
                'ue'   => array('ü'),
                'uu'   => array('ऊ'),
                'ya'   => array('я'),
                'yu'   => array('ю'),
                'zh'   => array('ж', 'ჟ', 'ژ'),
                '(c)'  => array('©'),
                'A'    => array('Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ', 'Ａ', 'Ä'),
                'B'    => array('Б', 'Β', 'ब', 'Ｂ'),
                'C'    => array('Ç', 'Ć', 'Č', 'Ĉ', 'Ċ', 'Ｃ'),
                'D'    => array('Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ', 'Ｄ'),
                'E'    => array('É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə', 'Ｅ'),
                'F'    => array('Ф', 'Φ', 'Ｆ'),
                'G'    => array('Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ', 'Ｇ'),
                'H'    => array('Η', 'Ή', 'Ħ', 'Ｈ'),
                'I'    => array('Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ', 'Ｉ'),
                'J'    => array('Ｊ'),
                'K'    => array('К', 'Κ', 'Ｋ'),
                'L'    => array('Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल', 'Ｌ'),
                'M'    => array('М', 'Μ', 'Ｍ'),
                'N'    => array('Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν', 'Ｎ'),
                'O'    => array('Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ', 'Ｏ', 'Ö'),
                'P'    => array('П', 'Π', 'Ｐ'),
                'Q'    => array('Ｑ'),
                'R'    => array('Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ', 'Ｒ'),
                'S'    => array('Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ', 'Ｓ'),
                'T'    => array('Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ', 'Ｔ'),
                'U'    => array('Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ', 'Ｕ', 'Ў', 'Ü'),
                'V'    => array('В', 'Ｖ'),
                'W'    => array('Ω', 'Ώ', 'Ŵ', 'Ｗ'),
                'X'    => array('Χ', 'Ξ', 'Ｘ'),
                'Y'    => array('Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ', 'Ｙ'),
                'Z'    => array('Ź', 'Ž', 'Ż', 'З', 'Ζ', 'Ｚ'),
                'AE'   => array('Æ', 'Ǽ'),
                'Ch'   => array('Ч'),
                'Dj'   => array('Ђ'),
                'Dz'   => array('Џ'),
                'Gx'   => array('Ĝ'),
                'Hx'   => array('Ĥ'),
                'Ij'   => array('Ĳ'),
                'Jx'   => array('Ĵ'),
                'Kh'   => array('Х'),
                'Lj'   => array('Љ'),
                'Nj'   => array('Њ'),
                'Oe'   => array('Œ'),
                'Ps'   => array('Ψ'),
                'Sh'   => array('Ш'),
                'Shch' => array('Щ'),
                'Ss'   => array('ẞ'),
                'Th'   => array('Þ'),
                'Ts'   => array('Ц'),
                'Ya'   => array('Я'),
                'Yu'   => array('Ю'),
                'Zh'   => array('Ж'),
                ' '    => array("\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80", "\xEF\xBE\xA0")
            );
        }

        /**
         * Returns the language specific replacements for the ascii method.
         *
         * Note: Adapted from Stringy\Stringy.
         *
         * @see https://github.com/danielstjules/Stringy/blob/3.1.0/LICENSE.txt
         *
         * @param  string  $language
         * @return array|null
         */
        protected static function languageSpecificCharsArray($language)
        {
            static $languageSpecific;

            if (! isset($languageSpecific)) {
                $languageSpecific = array(
                    'bg' => array(
                        array('х', 'Х', 'щ', 'Щ', 'ъ', 'Ъ', 'ь', 'Ь'),
                        array('h', 'H', 'sht', 'SHT', 'a', 'А', 'y', 'Y')
                    ),
                    'de' => array(
                        array('ä',  'ö',  'ü',  'Ä',  'Ö',  'Ü'),
                        array('ae', 'oe', 'ue', 'AE', 'OE', 'UE')
                    )
                );
            }

            return isset($languageSpecific[$language]) ? $languageSpecific[$language] : null;
        }
    }
