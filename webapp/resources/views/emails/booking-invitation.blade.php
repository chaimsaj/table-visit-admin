@extends('emails.layouts.email-layout')
@section('content')
    <!-- Email Wrapper Body Open // -->
    <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%"
           class="wrapperBody">
        <tr>
            <td align="center" valign="top">

                <!-- Table Card Open // -->
                <table border="0" cellpadding="0" cellspacing="0"
                       style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;"
                       width="100%" class="tableCard">

                    <tr>
                        <!-- Header Top Border // -->
                        <td height="3" style="background-color:#ffbd59;font-size:1px;line-height:3px;"
                            class="topBorder">&nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td align="center" valign="top"
                            style="padding-bottom:5px;padding-left:20px;padding-right:20px;"
                            class="mainTitle">
                            <!-- Main Title Text // -->
                            <h2 class="text"
                                style="color:#000000; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:28px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0">
                                Hi "John Doe"
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top"
                            style="padding-bottom:30px;padding-left:20px;padding-right:20px;"
                            class="subTitle">
                            <!-- Sub Title Text // -->
                            <h4 class="text"
                                style="color:#999999; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:18px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:0">
                                You've been Invited
                            </h4>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" valign="top" style="padding-left:20px;padding-right:20px;"
                            class="containtTable">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                   class="tableSmllTitle">
                                <tr>
                                    <td align="center" valign="top" style="padding-bottom:10px;"
                                        class="smllTitle">
                                        <!-- Small Title Text // -->
                                        <p class="text"
                                           style="color:#000000; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:18px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:26px; text-transform:none; text-align:center; padding:0; margin:0">
                                            Logan Paul
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="center" valign="top" style="padding-bottom:20px;"
                                        class="smllSubTitle">
                                        <!-- Info Title Text // -->
                                        <p class="text"
                                           style="color:#BBBBBB; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:16px; font-weight:600; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
                                            CEO and Founder, Notify
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                   class="tableDescription">
                                <tr>
                                    <td align="center" valign="top" style="padding-bottom:20px;"
                                        class="description">
                                        <!-- Description Text// -->
                                        <p class="text"
                                           style="color:#666666; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:14px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
                                            Already use Notify? You'll be able to use the same login to join
                                            Logan Paul's account. or, you can create a new login to join
                                            this account.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                   class="tableButton">
                                <tr>
                                    <td align="center" valign="top"
                                        style="padding-top:20px;padding-bottom:20px;">

                                        <!-- Button Table // -->
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" class="ctaButton"
                                                    style="background-color:#ffbd59;padding-top:12px;padding-bottom:12px;padding-left:35px;padding-right:35px;border-radius:50px">
                                                    <!-- Button Link // -->
                                                    <a class="text" href="#" target="_blank"
                                                       style="color:#FFFFFF; font-family:'Open Sans', Helvetica, Arial, sans-serif; font-size:13px; font-weight:700; font-style:normal;letter-spacing:1px; line-height:20px; text-transform:uppercase; text-decoration:none; display:block">
                                                        Join Account
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <tr>
                        <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                    </tr>
                </table>
                <!-- Table Card Close// -->

                <!-- Space -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
                    <tr>
                        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    <!-- Email Wrapper Body Close // -->
@endsection
