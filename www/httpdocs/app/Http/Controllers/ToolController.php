<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToolController extends Controller {

	public function __construct(Request $request)
	{
		parent::__construct($request);
		$this->url_pattern = "tool";
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function pdf_get()
	{
// dd($this->url_pattern);
		// return view($this->url_pattern . '.pdf');
		return view('tool.pdf');
	}

	// https://github.com/barryvdh/laravel-snappy
	public function pdf_post()
	{
		// require('fpdf.php');

		// $pdf = new \App\Help\FPDF();
		// $pdf->AddPage();
		// $pdf->SetFont('Arial','B',16);
		// $pdf->Cell(40,10,'Hello World!');
		// $pdf->Output();


		// $html = '<h1>Bill</h1><p>You owe me money, dude.</p>';

		// $snappy = \App::make('snappy.pdf');
		//To file
		// $snappy->generateFromHtml('<h1>Bill</h1><p>You owe me money, dude.</p>', '/tmp/bill-123.pdf');
		// $snappy->generate('http://www.github.com', '/tmp/github.pdf'));

		// //Or output:
		// return new Response(
		//     $snappy->getOutputFromHtml($html),
		//     200,
		//     array(
		//         'Content-Type'          => 'application/pdf',
		//         'Content-Disposition'   => 'attachment; filename="snappy.pdf"'
		//     )
		// );

// $pdf = \App::make('snappy.pdf.wrapper');
// $pdf->loadHTML($html);
// return $pdf->inline();

		return view($this->url_pattern . '.pdf');
		exit;
	}

}
