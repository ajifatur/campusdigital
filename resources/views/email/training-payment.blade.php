<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

		.header {color: #333; font-size: 19px; font-weight: bold; text-shadow: 0 1px 0 white;}
		.content-cell {font-size: 16px; line-height: 1.5;}
        .button {font-size: 16px; margin-bottom: 25px;}
		#logo {margin-bottom: 30px!important;}
		#td-content {color: #000000!important; text-align: justify!important;}
		#komisi-proof {text-align: center!important; width: 100%!important; margin: 20px 0px!important;}
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="750" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
										<table class="subcopy" width="100%" cellpadding="0" cellspacing="0" role="presentation">
											<tr id="tr-logo">
												<td align="center">
													<img id="logo" src="{{ asset('assets/images/logo/'.get_logo()) }}" width="200">
												</td>
											</tr>
											<tr>
												<td id="td-content">
													<strong>Hai,</strong>
													<br>
													Sekedar memberitahukan bahwa <strong>{{ is_object($user) ? $user->nama_user : $user }}</strong> telah melakukan pembayaran atas pelatihan <strong>{{ $pelatihan->nama_pelatihan }}</strong> dengan biaya sebesar <strong>Rp {{ number_format($pelatihan->fee,0,'.','.') }}</strong>.
													<br>
													Kode Invoice Anda adalah: <strong>{{ $pelatihan->inv_pelatihan }}</strong>
													<br>
													<img id="komisi-proof" src="{{ asset('assets/images/fee-pelatihan/'.$pelatihan->fee_bukti) }}">
													<br>
													Harap segera memverifikasi pembayaran tersebut. Terimakasih.
												</td>
											</tr>
										</table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

					<tr>
						<td>
							<table class="footer" align="center" width="750" cellpadding="0" cellspacing="0" role="presentation">
								<tr>
									<td class="content-cell" align="center">
										© {{ date('Y') }} {{ get_website_name() }}. All rights reserved.
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
