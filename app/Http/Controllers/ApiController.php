<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Http\Controllers\Controller;
use Response;

class ApiController extends Controller {

	protected $statusCode = 200;
    protected $inputErrors = [];
	protected $limit = 30;
	protected $maxLimit = 100;

	public function getStatusCode() {
		return $this->statusCode;
	}

	public function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;

		return $this;
	}

	public function getInputErrors() {
		return $this->inputErrors;
	}

	public function setInputErrors($inputErrors) {
		$this->inputErrors = $inputErrors;

		return $this;
	}

	public function respondNotFound($message = 'Not Found') {
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respond($data, $headers = []) {
		return Response::json($data, $this->getStatusCode(), $headers);
	}

    public function respondWithPagination(Paginator $restaurants, $data) {

        $data = array_merge($data, [
            'paginator' => [
                'total_count' => (int) $restaurants->total(),
                'total_pages' => (int) $restaurants->lastPage(),
                'current_page' => (int) $restaurants->currentPage(),
                'limit' => (int) $restaurants->perPage(),
            ]
        ]);
        return $this->respond($data);
    }

	public function respondWithError($message) {
        $error = [
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ];

        if($this->getInputErrors()) $error['input_errors'] = $this->getInputErrors();

		return $this->respond([
			'error' => $error,
		]);
	}

	public function getLimit() {
		return $this->limit;
	}

	public function setLimit(Request $request) {
		$this->limit = is_numeric($request->input('limit')) 
            && ($request->input('limit') <= $this->maxLimit) ? $request->input('limit') : $this->limit;
		return $this;
	}


}