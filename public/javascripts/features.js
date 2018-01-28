/**
 * Created by Thomas Müller on 24.10.2015.
 */

"use strict";

var m = Modernizr, c = '';

function convert(variable) {
    var c, cx = {}, t = typeof variable;

    if (t === 'object') {
        c = {};

        for (var s in variable) {
            if (!variable.hasOwnProperty(s)) {
                c[s] = 'u';
            } else {
                c[s] = convert(variable[s]);
            }
        }
    } else if (t === 'boolean') {
        c = (variable ? 't' : 'f');
    } else if (variable === null) {
        c = 'n';
    } else if (variable === '') {
        c = 'e';
    } else if (variable === 'probably') {
        c = 'p';
    } else if (variable === 'maybe') {
        c = 'm';
    } else if (variable === 'undefined') {
        c = 'v';
    } else {
        c = variable;
    }

    return c;
}

var x = {
    "adownload": "t",
    "ambientlight": "f",
    "apng": "",
    "appearance": "t",
    "applicationcache": "t",
    "arrow": "t",
    "atob-btoa": "t",
    "atobbtoa": "t",
    "audio": "t",
    "audio.m4a": "",
    "audio.mp3": "",
    "audio.ogg": "",
    "audio.opus": "",
    "audio.wav": "",
    "audioloop": "t",
    "backdropfilter": "f",
    "backgroundblendmode": "t",
    "backgroundcliptext": "t",
    "backgroundsize": "t",
    "battery-api": "f",
    "batteryapi": "f",
    "bdi": "t",
    "beacon": "t",
    "bgpositionshorthand": "t",
    "bgpositionxy": "t",
    "bgrepeatround": "t",
    "bgrepeatspace": "t",
    "bgsizecover": "t",
    "blob-constructor": "t",
    "blobconstructor": "t",
    "bloburls": "t",
    "blobworkers": "",
    "borderimage": "t",
    "borderradius": "t",
    "boxshadow": "t",
    "boxsizing": "t",
    "canvas": "t",
    "canvasblending": "t",
    "canvastext": "t",
    "canvaswinding": "t",
    "capture": "f",
    "checked": "t",
    "classlist": "t",
    "contains": "f",
    "contenteditable": "t",
    "contextmenu": "f",
    "cookies": "t",
    "core-desktop": "t",
    "core-mobile": "f",
    "core-tablet": "f",
    "cors": "t",
    "createelement-attrs": "f",
    "createelementattrs": "f",
    "crypto": "t",
    "cssall": "t",
    "cssanimations": "t",
    "csscalc": "t",
    "csschunit": "t",
    "csscolumns": "",
    "csscolumns.breakafter": "",
    "csscolumns.breakbefore": "",
    "csscolumns.breakinside": "",
    "csscolumns.fill": "",
    "csscolumns.gap": "",
    "csscolumns.rule": "",
    "csscolumns.rulecolor": "",
    "csscolumns.rulestyle": "",
    "csscolumns.rulewidth": "",
    "csscolumns.span": "",
    "csscolumns.width": "",
    "cssescape": "t",
    "cssexunit": "t",
    "cssfilters": "t",
    "cssgradients": "t",
    "cssgrid": "t",
    "cssgridlegacy": "t",
    "csshyphens": "",
    "csstransformslevel2": "",
    "customelements": "",
    "hovermq": "",
    "messagechannel": "",
    "passiveeventlisteners": "",
    "pointermq": "",
    "urlsearchparams": "",
    "videocrossorigin": "",
    "softhyphens": "",
    "softhyphensfind": "",
    "cssinvalid": "t",
    "cssmask": "t",
    "csspointerevents": "t",
    "csspositionsticky": "f",
    "csspseudoanimations": "t",
    "csspseudotransitions": "t",
    "cssreflections": "t",
    "cssremunit": "t",
    "cssresize": "t",
    "cssscrollbar": "t",
    "csstransforms": "t",
    "csstransforms3d": "t",
    "csstransitions": "t",
    "cssvalid": "t",
    "cssvhunit": "t",
    "cssvmaxunit": "t",
    "cssvminunit": "t",
    "cssvwunit": "t",
    "cubicbezierrange": "t",
    "customevent": "t",
    "customprotocolhandler": "t",
    "dart": "f",
    "datachannel": "t",
    "datalistelem": "t",
    "dataset": "t",
    "datauri": "",
    "datauri.over32kb": "",
    "dataview": "t",
    "dataworkers": "",
    "details": "t",
    "devicemotion": "t",
    "deviceorientation": "t",
    "display-runin": "f",
    "display-table": "t",
    "displayrunin": "f",
    "displaytable": "t",
    "documentfragment": "t",
    "ellipsis": "t",
    "emoji": "t",
    "es5": "t",
    "es5array": "t",
    "es5date": "t",
    "es5function": "t",
    "es5object": "t",
    "es5string": "t",
    "es5syntax": "t",
    "es5undefined": "t",
    "es6array": "f",
    "es6collections": "t",
    "es6math": "t",
    "es6number": "t",
    "es6object": "t",
    "es6string": "f",
    "eventlistener": "t",
    "eventsource": "t",
    "exiforientation": "",
    "draganddrop": "",
    "fetch": "t",
    "file": "",
    "fileapi": "",
    "fileinput": "t",
    "fileinputdirectory": "t",
    "filereader": "t",
    "filesystem": "t",
    "flash": "f",
    "flexbox": "t",
    "flexboxlegacy": "t",
    "flexboxtweener": "f",
    "flexwrap": "t",
    "fontface": "t",
    "forcetouch": "f",
    "formattribute": "t",
    "formvalidation": "t",
    "formvalidationapi": "t",
    "formvalidationmessage": "t",
    "framed": "f",
    "fullscreen": "t",
    "gamepads": "t",
    "generatedcontent": "t",
    "generators": "t",
    "geolocation": "t",
    "getrandomvalues": "t",
    "getusermedia": "t",
    "hairline": "f",
    "hashchange": "t",
    "hidden": "t",
    "hiddenscroll": "f",
    "history": "t",
    "hsla": "t",
    "htmlimports": "t",
    "ie8compat": "f",
    "imgcrossorigin": "t",
    "indexeddb": "",
    "indexeddb.deletedatabase": "",
    "indexeddbblob": "",
    "inlinesvg": "t",
    "input.autocomplete": "",
    "input.autofocus": "",
    "input.list": "",
    "input.max": "",
    "input.min": "",
    "input.multiple": "",
    "input.pattern": "",
    "input.placeholder": "",
    "input.required": "",
    "input.step": "",
    "input": "",
    "input-formaction": "t",
    "input-formenctype": "t",
    "input-formtarget": "f",
    "inputformaction": "t",
    "inputformenctype": "t",
    "inputformmethod": "t",
    "inputformtarget": "f",
    "inputsearchevent": "t",
    "inputtypes.color": "",
    "inputtypes.date": "",
    "inputtypes.datetime": "",
    "inputtypes.datetime-local": "",
    "inputtypes.email": "",
    "inputtypes.month": "",
    "inputtypes.number": "",
    "inputtypes.range": "",
    "inputtypes.search": "",
    "inputtypes.tel": "",
    "inputtypes.time": "",
    "inputtypes.url": "",
    "inputtypes.week": "",
    "intl": "t",
    "jpeg2000": "",
    "jpegxr": "",
    "json": "t",
    "lastchild": "t",
    "ligatures": "t",
    "localizednumber": "f",
    "localstorage": "t",
    "lowbandwidth": "f",
    "lowbattery": "f",
    "matchmedia": "t",
    "mathml": "f",
    "mediaqueries": "t",
    "meter": "t",
    "microdata": "f",
    "multiplebgs": "t",
    "mutationobserver": "t",
    "notification": "t",
    "nthchild": "t",
    "object-fit": "t",
    "objectfit": "t",
    "olreversed": "t",
    "oninput": "t",
    "opacity": "t",
    "outputelem": "t",
    "overflowscrolling": "f",
    "pagevisibility": "t",
    "peerconnection": "t",
    "performance": "t",
    "picture": "t",
    "placeholder": "t",
    "pointerevents": "f",
    "pointerlock": "t",
    "postmessage": "t",
    "pr-screenattributes.colorDepth": "",
    "pr-screenattributes.windowHeight": "",
    "pr-screenattributes.windowWidth": "",
    "preserve3d": "t",
    "progressbar": "t",
    "promises": "t",
    "proximity": "f",
    "ps-hirescapable": "f",
    "ps-lowbandwidth": "f",
    "ps-lowbattery": "f",
    "ps-max-cookiedata-length": 4142,
    "queryselector": "t",
    "quotamanagement": "t",
    "raf": "t",
    "regions": "f",
    "requestanimationframe": "t",
    "requestautocomplete": "f",
    "rgba": "t",
    "ruby": "t",
    "sandbox": "t",
    "scriptasync": "t",
    "scriptdefer": "t",
    "scrollsnappoints": "f",
    "seamless": "f",
    "serviceworker": "t",
    "sessionstorage": "t",
    "shapes": "t",
    "sharedworkers": "t",
    "siblinggeneral": "f",
    "sizes": "t",
    "smil": "t",
    "speechrecognition": "t",
    "speechsynthesis": "t",
    "srcdoc": "t",
    "srcset": "t",
    "strictmode": "t",
    "stylescoped": "f",
    "subpixelfont": "f",
    "supports": "t",
    "svg": "t",
    "svgasimg": "t",
    "svgclippaths": "t",
    "svgfilters": "t",
    "svgforeignobject": "t",
    "target": "t",
    "template": "t",
    "templatestrings": "t",
    "textalignlast": "t",
    "textareamaxlength": "t",
    "textshadow": "t",
    "texttrackapi": "t",
    "time": "f",
    "todataurljpeg": "t",
    "todataurlpng": "t",
    "todataurlwebp": "t",
    "touchevents": "f",
    "track": "t",
    "transferables": "t",
    "typedarrays": "t",
    "unicode": "t",
    "unicoderange": "t",
    "unknownelements": "t",
    "urlparser": "t",
    "userdata": "f",
    "userselect": "t",
    "vibrate": "t",
    "video": "",
    "video.h264": "",
    "video.hls": "",
    "video.ogg": "",
    "video.vp9": "",
    "video.webm": "",
    "videoloop": "t",
    "videopreload": "t",
    "vml": "f",
    "webanimations": "t",
    "webaudio": "t",
    "webgl": "t",
    "webglextensions": "",
    "webglextensions.ANGLE_instanced_arrays": "t",
    "webglextensions.EXT_blend_minmax": "t",
    "webglextensions.EXT_disjoint_timer_query": "",
    "webglextensions.EXT_frag_depth": "t",
    "webglextensions.EXT_sRGB": "t",
    "webglextensions.EXT_shader_texture_lod": "t",
    "webglextensions.EXT_texture_filter_anisotropic": "t",
    "webglextensions.OES_element_index_uint": "t",
    "webglextensions.OES_standard_derivatives": "t",
    "webglextensions.OES_texture_float": "t",
    "webglextensions.OES_texture_float_linear": "t",
    "webglextensions.OES_texture_half_float": "t",
    "webglextensions.OES_texture_half_float_linear": "t",
    "webglextensions.OES_vertex_array_object": "t",
    "webglextensions.WEBGL_compressed_texture_etc1": "t",
    "webglextensions.WEBGL_compressed_texture_s3tc": "t",
    "webglextensions.WEBGL_debug_renderer_info": "t",
    "webglextensions.WEBGL_debug_shaders": "t",
    "webglextensions.WEBGL_depth_texture": "t",
    "webglextensions.WEBGL_draw_buffers": "t",
    "webglextensions.WEBGL_lose_context": "t",
    "webglextensions.WEBKIT_EXT_texture_filter_anisotropic": "t",
    "webglextensions.WEBKIT_WEBGL_compressed_texture_s3tc": "t",
    "webglextensions.WEBKIT_WEBGL_depth_texture": "t",
    "webglextensions.WEBKIT_WEBGL_lose_context": "t",
    "webglextensions.EXT_color_buffer_half_float": "t",
    "webglextensions.WEBGL_color_buffer_float": "t",
    "webglextensions.WEBGL_compressed_texture_s3tc_srgb": "t",
    "webintents": "f",
    "webpalpha": "",
    "webpanimation": "",
    "webplossless": "",
    "webp": "",
    "webp.alpha": "",
    "webp.animation": "",
    "webp.lossless": "",
    "websockets": "t",
    "websocketsbinary": "t",
    "websqldatabase": "t",
    "webworkers": "t",
    "willchange": "t",
    "wrapflow": "f",
    "xdomainrequest": "f",
    "xhr2": "t",
    "xhrresponsetype": "t",
    "xhrresponsetypearraybuffer": "t",
    "xhrresponsetypeblob": "t",
    "xhrresponsetypedocument": "t",
    "xhrresponsetypejson": "t",
    "xhrresponsetypetext": "t"
};

var result = {}, t;

for (var property in x) {
    if (!x.hasOwnProperty(property)) {
        result[property] = 'u';

        continue;
    }

    result[property] = 'x';

    var featureNameSplit = property.split('.');

    if (featureNameSplit.length === 1) {
        if (typeof m[property] === 'undefined') {
            result[property] = 'u';
        } else if (typeof m[property] === 'object') {
            result[property] = convert(!!m[property]);

            for (var p in m[property]) {
                if (m[property].hasOwnProperty(p)) {
                    result[property + '.' + p] = convert(m[property][p]);
                } else if (m.hasOwnProperty(property + p)) {
                    result[property + '.' + p] = convert(m[property + p]);
                    result[property + p] = convert(m[property + p]);
                } else if (m.hasOwnProperty(p)) {
                    result[property + '.' + p] = convert(m[p]);
                    result[p] = convert(m[p]);
                } else {
                    result[property + '.' + p] = 'u';
                }
            }
        } else {
            result[property] = convert(m[property]);
        }
    } else if (!m.hasOwnProperty(featureNameSplit[0]) || typeof m[featureNameSplit[0]] === 'undefined') {
        result[property] = 'u';
    } else if (!m[featureNameSplit[0]].hasOwnProperty(featureNameSplit[1]) || typeof m[featureNameSplit[0]][featureNameSplit[1]] === 'undefined') {
        result[property] = 'u';
    } else {
        result[property] = convert(m[featureNameSplit[0]][featureNameSplit[1]]);
    }
}

var missing = {};

for (var f in m) {
    if (!m.hasOwnProperty(f)) {
        continue;
    }

    if (f[0] === '_') {
        continue;
    }

    var w = typeof m[f];

    if (w === 'function') {
        continue;
    }

    if (w === 'object') {
        for (var s in m[f]) {
            if (!m[f].hasOwnProperty(s)) {
                continue;
            }

            if (x.hasOwnProperty(f + '.' + s)) {
                continue;
            }

            missing[f + '.' + s] = 1;
        }
    } else {
        if (x.hasOwnProperty(f)) {
            continue;
        }

        missing[f] = 1;
    }
}
