<!DOCTYPE html>
<html data-wf-page="592d6c1e77d1db4322b6ad69" data-wf-site="59278e73520feb673bb142eb">
<head>
    <meta charset="utf-8">
    <title>Form Admin</title>
    <meta content="Form Admin" property="og:title">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
    <script type="text/javascript">
    WebFont.load({
        google: {
            families: ["Muli:200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,800,800italic,900,900italic"]
        }
    });
    </script>
    <script type="text/javascript">
    ! function(o, c) {
        var n = c.documentElement,
            t = " w-mod-";
        n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
    }(window, document);
    </script>
    <link href="https://daks2k3a4ib2z.cloudfront.net/img/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="https://daks2k3a4ib2z.cloudfront.net/img/webclip.png" rel="apple-touch-icon">
</head>

<body>
    <div class="admin-header w-clearfix">
        <div>
            <img class="header-logo" src="/images/RQ-logo-transparent-mono-02.svg">
            <div class="admin-page-indicator">
                <span class="current-page">Form Admin</span> | Select Form to Edit
            </div>
        </div>

        <div class="search-row">
            <img class="search-icon" src="/images/search-icon.png">
            <div class="form-wrapper w-form">
                <form data-name="Email Form" id="email-form" name="email-form">
                    <input type="text"
                        id="Form-Search" 
                        name="Form-Search" 
                        class="text-field w-input" 
                        data-name="Form Search" 
                        maxlength="256" 
                        placeholder="Search / Jump-to Form">
                </form>
            </div>
        </div>
    </div>

    <div class="form-home">
        <div class="form-home-form">
            <img class="plus" src="/images/blue-plus.svg">
            <div class="create-new-form">Create a new form</div>
            <a class="link-block w-inline-block" href="/forms/create"></a>
        </div>

        @foreach ($forms as $form)
        <div class="form-home-form">
            <div class="text-block-3">Form Name</div>
            <div class="form-home-bottom-bar">
                <div class="form-home-dates">Created: 5/30/17
                    <br>Last Edited: 5/30/17
                    <br>Submissions: 10
                    <br>Last Submitted: 5/30/17</div>
            </div>
        </div>
        @endforeach

    </div>

    <div class="admin-footer"></div>

    <script src="/js/app.js" type="text/javascript"></script>
</body>
</html>
