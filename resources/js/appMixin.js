import moment from 'moment-timezone'
import Vue from 'vue'

export default {

    methods: {

        randomInt(min, max) {
            return min + Math.floor((max - min) * Math.random())
        },
        escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;")
        },

        isEmpty(value) {
            if (typeof value === 'object') {
                if (value == null) return true
                if (value.length == 0) return true
            }
            if (value === undefined) return true
            if (value === null) return true
            if (value === '') return true
        },

        getSplitted(str, splitter, index) {
            if (typeof str == "undefined") return ""
            var valuesArray = str.split(splitter)
            if (typeof valuesArray[index] != "undefined") {
                return valuesArray[index]
            }
            return ''
        },

        getFilenameOfPath(Filename) {
            var valuesArray = Filename.split('/')
            console.log('valuesArray::')
            console.log(valuesArray)
            console.log(typeof valuesArray)

            if (typeof valuesArray[valuesArray.length - 1] != "undefined") {
                let res = valuesArray[valuesArray.length - 1]
                console.log('res++::')
                console.log(res)
                return res
            }
            return false
        },


        userHasAvatar(user) {
            if (typeof user['filenameData'] == "undefined") return false
            if (user['filenameData'] === null) return false
            if (typeof user['filenameData'].avatar_url == "undefined") return false
            if (typeof user['filenameData'].avatar_url == "string") return true
            return true
        },

        taskHasImage(task) {
            if (typeof task['filenameData'] == "undefined") return false
            if (task['filenameData'] === null) return false
            if (typeof task['filenameData'].image_url == "undefined") return false
            if (typeof task['filenameData'].image_url == "string") return true
            return true
        },

        categoryHasImage(category) {
            if (typeof category['filenameData'] == "undefined") return false
            if (category['filenameData'] === null) return false
            if (typeof category['filenameData'].image_url == "undefined") return false
            if (typeof category['filenameData'].image_url == "string") return true
            return true
        },

        pollingNotificationHasImage(pollingNotification) {
            if (typeof pollingNotification['filenameData'] == "undefined") return false
            if (pollingNotification['filenameData'] === null) return false
            if (typeof pollingNotification['filenameData'].image_url == "undefined") return false
            if (typeof pollingNotification['filenameData'].image_url == "string") return true
            return true
        },

        getFileSizeAsString: function (file_size) {
            if (parseInt(file_size) < 1024) {
                return file_size + 'b'
            }
            if (parseInt(file_size) < 1024 * 1024) {
                return Math.floor(file_size / 1024) + 'kb'
            }
            return Math.floor(file_size / (1024 * 1024)) + 'mb'
        },

        convertObjectToArray: function (obj) {
            var result = Object.keys(obj).map(function (key) {
                return [Number(key), obj[key]]
            })
            return result
        },

        getArrayKeyValues: function (dataArray, key) {
            let retArray = []
            dataArray.map((nextItem) => {
                if (typeof nextItem[key] !== 'undefined') {
                    retArray[retArray.length] = nextItem[key]
                }
            })
            return retArray
        },

        concatStrings: function (dataArray, splitter) {
            var ret = ''
            var L = dataArray.length
            let resArray = []
            for (let I = 0; I < L; I++) {
                var next_string = this.trim(dataArray[I])
                if (typeof next_string === 'string') {
                    if (next_string.length > 0) {
                        resArray[resArray.length] = next_string
                    }
                }
            }
            L = resArray.length
            resArray.map((next_string, index) => {
                next_string = this.trim(next_string)
                if (typeof next_string === 'string') {
                    if (next_string) {
                        if (L === index + 1) {
                            ret = ret + next_string
                        } else {
                            ret = ret + next_string + splitter
                        }
                    } // if ( next_string ) {
                }
            })
            return ret
        },


        getClone: function (obj) {
            let copy = JSON.parse(JSON.stringify(obj))
            return copy
        },

        setAppTitle: function (page_group, page_title, bus) {
            var site_name = process.env.VUE_APP_SITE_NAME
            bus.$emit('appPageTitleSet', page_group, page_title)

            if (typeof page_title !== 'undefined' && page_title !== '' && site_name !== 'undefined' && site_name != '') {
                if (document.getElementById("app_title")) {
                    document.getElementById("app_title").innerHTML = page_title + ' of ' + site_name
                }
            }
        },

        clearTags: function (str) {
            if (typeof str != "string") return ""
            return str.replace(/<\/?[^>]+(>|$)/g, "")
        },

        isValidJsonString(str) {
            try {
                JSON.parse(str)
            } catch (e) {
                return false
            }
            return true
        },

        trim: function (str) {
            if (typeof str != "string") return ""
            return str.replace(/^\s+|\s+$/gm, '')
        },


        getVueVersion() {
            return Vue.version
        },

        noWrapString(str) {
            return this.replaceAll(str, ' ', '&nbsp;')
        },

        replaceAll(str, search, replacement) {
            return str.replace(new RegExp(search, 'g'), replacement)
        },

        clearErrorLabel(s, dataContainer) {
            if (typeof s === 'undefined') return ''
            return s.replace(dataContainer, '').replace(/_/g, ' ')
        },

        showPopupDialog: function (title, message, type) { // https://github.com/euvl/vue-notification
            this.$notify({
                group: 'vtasks_popup_dialog',
                title: title,
                text: message,
                type: type, // success  / warn / danger
                duration: -1, // 5000
                position: 'top center',
                speed: 1000
            })
        }, // showPopupDialog: function (message, type) {

        showPopupMessage: function (title, message, type) { // https://github.com/euvl/vue-notification
            this.$notify({
                group: 'vtasks_notification',
                title: title,
                text: message,
                type: type, // success  / warn / danger
                duration: 1000, // 5000
                position: 'top left',
                speed: 1000
            })
        }, // showPopupMessage: function (message, type) {

        concatStr: function (str, maxStrLengthInListing) {
            if (typeof str === 'undefined') str = ''
            if (str.length > maxStrLengthInListing) {
                return str.slice(0, maxStrLengthInListing) + '...'
            }
            return str
        },

        getKeyByValue(object, value) {
            if (typeof object[value] === 'undefined') return ''
            return object[value]
        },

        moneyFormat(price) {
            if (typeof price === 'undefined' || typeof price === 'object') {
                price = 0
            }
            if (typeof price === 'string') {
                price = parseFloat(price)
            }
            return '$' + price.toFixed(2)
        },

        momentDatetime(datetime, datetimeFormat, defaultVal) {
            if (typeof datetime === 'undefined' || datetime === null) {
                if (typeof defaultVal !== 'undefined' && defaultVal != null) {
                    return defaultVal
                }
                return ''
            }
            if (typeof datetime === 'object') {
                return moment(datetime).format(datetimeFormat)
            }
            if (typeof datetime === 'string') {
                if (datetimeFormat === '') return ''
                let dt = moment(String(datetime))
                return dt.format(datetimeFormat)
            } // if (typeof datetime === "string") {
            return ''
        }, // momentDatetime(datetime, datetimeFormat, defaultVal) {

        timeInAgoFormat: function (value) {
            if (value == null || typeof value === 'undefined') return
            return this.Capitalize(moment(value).fromNow())
        },

        getDictionaryLabel(value, selectionsList, defaultValue) {
            if (typeof defaultValue === 'undefined') defaultValue = ''
            if (typeof selectionsList === 'undefined') return defaultValue
            var ret = defaultValue
            selectionsList.map((nextSelection/*, index*/) => {
                if (nextSelection.code === value) {
                    ret = nextSelection.label
                }
            })
            return ret
        }, // getDictionaryLabel( value, selectionsList, defaultValue ) {

        Uppercase: function (string) {
            if (typeof string != "string") return ""
            return string.toUpperCase()
        },

        lowerCase: function (string) {
            if (typeof string != "string") return ""
            return string.toLowerCase(0)
        },

        Capitalize: function (string) {
            if (typeof string != "string") return ""
            return string.charAt(0).toUpperCase() + string.slice(1)
        },

        clearErrorMessage(s) {
            if (typeof s === 'undefined') return ''
            return this.Capitalize(s.replace(/_/g, ' '))
        },

        isSameDay(dat_1, dat_2) {
            let m_1 = dat_1.getMonth() + 1 // getMonth() is zero-based
            let d_1 = dat_1.getDate()
            let y_1 = dat_1.getFullYear()
            let m_2 = dat_2.getMonth() + 1 // getMonth() is zero-based
            let d_2 = dat_2.getDate()
            let y_2 = dat_2.getFullYear()
            console.log('isSameDay ::')
            console.log((m_1 == m_2 && d_1 == d_2 && y_1 == y_2))

            return (m_1 == m_2 && d_1 == d_2 && y_1 == y_2)
        },


        dateToMySqlFormat(dat) {
            // console.log('-- dateToMySqlFormat dat::')
            // console.log(dat)

            if (typeof dat === 'string') {
                dat = moment(dat)
                dat = moment(dat, 'Do MM YYYY')//.toDate()
                // console.log('++INSIDE dat::')
                // console.log(dat)
                // dat = moment.utc(dat,'Do MM YYYY')//.toDate()
                //01 Oct 2018
            }
            var mm = dat.format('M') // getMonth() is zero-based
            // var dd = dat.day()
            var dd = dat.format('D')
            // console.log('dateToMySqlFormat dd::')
            // console.log(dd)


            /*
                        console.log('dat.format(\'d\')::')
                        console.log(dat.format('d'))

                        console.log([dat.year(),
                            (mm > 9 ? '' : '0') + mm,
                            (dd > 9 ? '' : '0') + dd
                        ].join('-'))
            */

            return [dat.year(),
                (mm > 9 ? '' : '0') + mm,
                (dd > 9 ? '' : '0') + dd
            ].join('-')
        },

        dateTimeToMySqlFormat(dat) {
            // console.log('dateTimeToMySqlFormat dat::')
            // console.log(dat)
            // console.log(typeof dat)

            if (typeof dat === 'string') {
                // 2020-04-07T22:00:00.000Z
                /*
                                dat= dat.replace(/T/g, " ").replace(/Z/g, "").replace(/.000/g, "")
                                console.log('INSIDE dateTimeToMySqlFormat dat::')
                                console.log(dat)
                                console.log(typeof dat)

                                console.log('moment(dat)::')
                                console.log(moment(dat))
                                console.log(typeof moment(dat))
                */

                dat = moment(dat)
            }

            /*
                        console.log('AFTER dateTimeToMySqlFormat dat::')
                        console.log(dat)
                        console.log(typeof dat)
            */

            var mm = dat.format('M') // getMonth() is zero-based
            // var dd = dat.day()
            var dd = dat.format('D')
            /*
                        console.log('dd::')
                        console.log(dd)

                        console.log('dat.format(\'D\')::')
                        console.log(dat.format('D'))
            */

            var hour = dat.hour()
            var minute = dat.minutes()
            var second = dat.seconds()
            return [dat.year(),

                (mm > 9 ? '' : '0') + mm,
                (dd > 9 ? '' : '0') + dd
            ].join('-') + ' ' + hour + ':' + minute + ':' + second
        },

        addDaysToDate(add_days, current_date) {
            if (typeof current_date === 'undefined') {
                current_date = new Date()
            }
            current_date.setDate(current_date.getDate() + add_days)
            return current_date
        },

    }

}
