<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$details['subject']}}</title>
    <link href="{{ url('/css/fonts.css') }}" rel="stylesheet">
    <style>
        @media only screen and (max-width: 600px) {
            .main {
                width: 320px !important;
            }

            .top-image {
                width: 100% !important;
            }
            .inside-footer {
                width: 320px !important;
            }
            table[class="contenttable"] {
                width: 320px !important;
                text-align: left !important;
            }
            td[class="force-col"] {
                display: block !important;
            }
            td[class="rm-col"] {
                display: none !important;
            }
            .mt {
                margin-top: 15px !important;
            }
            *[class].width300 {
                width: 255px !important;
            }
            *[class].block {
                display: block !important;
            }
            *[class].blockcol {
                display: none !important;
            }
            .emailButton {
                width: 100% !important;
            }

            .emailButton a {
                display: block !important;
                font-size: 18px !important;
            }
        }
        *{
            font-family: Vazir !important;
        }
    </style>
</head>
<body link="#42B5D3" vlink="#42B5D3" alink="#42B5D3" color="black" dir="rtl">
<table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
    <tr>
        <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
            <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                <tr>
                    <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;text-align: center;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #42B5D3">
                        <a href="{{$setting->url}}"><img style="background-color:white;width: 100px;padding: 10px" class="top-image" src="{{$setting->logo->address??null}}" alt="{{$setting->title}}"></a>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
                        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                            <tr style="padding-top: 20px;margin:20px;">
                                <td class="head-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 20px;line-height: 34px;font-weight: bold; text-align: center;">
                                    <div class="mktEditable" id="main_title">
                                        {{$setting->title}}
                                    </div>
                                </td>
                            </tr>
                            <tr style="padding-top: 20px;">
                                <td  class="head-title">
                                    <div style="text-align: right" >
                                        <span>موضوع :</span>
                                        {{$details['text_subject']}}
                                    </div>
                                </td>
                            </tr>
                            <tr style="margin:10px">
                                <td class="head-title" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 18px;line-height: 34px;font-weight: bold; text-align: center;">
                                    <div class="mktEditable"  style="color:red; padding-top: 20px;direction: ltr !important;">
                                        {{$details['text']}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 5px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;"></td>
                            </tr>
                            <tr>
                                <td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 15px 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 21px;">
                                    <hr size="1" color="#eeeff0">
                                </td>
                            </tr>

                            <tr>
                                <td class="grey-block" style="border-collapse: collapse;border: 0;margin: 0;padding: 18px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;background-color: #fff; border-top: 3px solid #42B5D3; border-left: 1px solid #E6E6E6; border-right: 1px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; text-align: center;">
                                    <span style="font-family: Arial, sans-serif; font-size: 24px; line-height: 39px; border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559; text-align: center;font-weight: bold;">لیست محصولات ما</span><br>
                                    <br><br>
                                    <a style="color:#ffffff; background-color: #42B5D3;  border-top: 10px solid #42B5D3; border-bottom: 10px solid #42B5D3; border-left: 20px solid #42B5D3; border-right: 20px solid #42B5D3; border-radius: 3px; text-decoration:none;" href="{{$setting->url}}">آدرس ما</a>

                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="center" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
                                    <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                                        <tr>
                                            <td align="center" valign="middle" class="social" style="border-collapse: collapse;border: 0;margin: 0;padding: 10px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;text-align: center;">
                                                <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                                                    <tr>
                                                        @if($setting->media->telegram??null)
                                                            <a href="{{$setting->media->telegram}}" target="_blank" title="telegram" style="margin:10px;text-decoration: none;">
                                                                <img src="https://www.svgrepo.com/show/473804/telegram.svg" alt="Linkedin" style="width: 20px;">
                                                            </a>
                                                        @endif
                                                        @if($setting->media->facebook??null)
                                                            <a href="{{$setting->media->facebook}}" target="_blank" title="facebook" style="margin:10px;text-decoration: none;">
                                                                <img src="https://static.tenable.com/marketing/icons/social/SVG/footer-icon-facebook.svg" alt="Facebook" style="width: 20px; height: 20px;">
                                                            </a>
                                                        @endif
                                                        @if($setting->media->instagram??null)
                                                            <a href="{{$setting->media->instagram}}" target="_blank" title="instagram" style="margin:10px;text-decoration: none;">
                                                                <img src="https://static.tenable.com/marketing/icons/social/SVG/instagram-no-circle.svg" alt="Instagram" style="width: 20px;">
                                                            </a>
                                                        @endif
                                                        @if( $setting->media->x_link??null)
                                                            <a href="{{$setting->media->x_link}}" target="_blank" title="twitter" style="margin:10px;text-decoration: none;">
                                                                <img src="https://static.tenable.com/marketing/icons/social/SVG/footer-icon-twitter.svg" alt="Twitter" style="width: 20px;">
                                                            </a>
                                                        @endif
                                                        @if($setting->media->youtube??null)
                                                            <a href="{{$setting->media->youtube}}" target="_blank" title="youtube" style="margin:10px;text-decoration: none;">
                                                                <img src="https://static.tenable.com/marketing/icons/social/SVG/footer-icon-youtube.svg" alt="Youtube" style="width: 20px;">
                                                            </a>
                                                        @endif
                                                        @if($setting->media->linkedin??null)
                                                            <a href="{{$setting->media->linkedin}}" target="_blank" title="linkedin" style="margin:10px;text-decoration: none;">
                                                                <img src="https://static.tenable.com/marketing/icons/social/SVG/footer-icon-linkedin.svg" alt="Linkedin" style="width: 20px;">
                                                            </a>
                                                        @endif
                                                        @if($setting->media->whatsapp??null)
                                                            <a href="{{$setting->media->whatsapp}}" target="_blank" title="whatsapp" style="margin:10px;text-decoration: none;">
                                                                <img src="https://www.svgrepo.com/show/106976/whatsapp.svg" alt="Linkedin" style="width: 20px;">
                                                            </a>
                                                        @endif
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr bgcolor="#fff" style="border-top: 4px solid #42B5D3;">
                                <td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
                                    <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                                        <tr>
                                            <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
                                                <div id="address" class="mktEditable">
                                                    <b><font color="#42B5D3">{{$setting->title}}</font> </b><br>
                                                    {{$setting->copy_right}}<br> {{$setting->email??''}} <br> {{$setting->tel??''}} <br>
                                                    <a style="color: #42B5D3;" href="{{$setting->url.'/contact-us'}}">ارتباط با ما</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
