<?php
namespace App\Controllers\Admin;
use Core\Controller;
use App\Models\Payment;
use App\Models\PaymentDetail;

class OrderController extends Controller{
    public function index(){
        $payment = new Payment();
        $page = (request('page')) ? request('page') : 1;
        $limit = 5;
        $pagination = handlPagination($limit, $page, 'payments');
        $listPayment = $payment->limit($limit, $pagination['start'])->get();
        $total_page = $pagination['total'];
        return $this->view('admin.order.index', compact('listPayment', 'page', 'total_page'));

    }

    public function detail($id)
    {
        $payment = new Payment();
        $payment_detail = new PaymentDetail();
        $dataPaymentDetail = $payment_detail->join('carts c', 'c.id = p.cart_id')->where('p.payment_id', $id)->get();
        $dataPayment = $payment->where('id', $id)->getOne();

        if (!$dataPayment || count($dataPaymentDetail) <= 0) {
            return redirect('404');
        }
        return $this->view('admin.order.detail', compact('dataPayment', 'dataPaymentDetail'));
    }

    public function update(){
        $result = [
            'status' => 'error',
            'message' => '',
            'error' => false
        ];

        $payment = new Payment();
        $id = request('id');
        $status = request('status');

        $data = $payment->where('id', $id)->getOne();

        if (!$data) {
            $result['message'] = 'Lỗi! Đơn hàng không tồn tại!';
            echo json_encode($result);
            return;

        }

        $user = getSession('user');
        $payment = new Payment();
        $payment->status = $status;
        $data = $payment->where('id', $id)->update();

        if ($data) {
            $result['status'] = 'success';
            $result['message'] = 'Update thành công!';
            echo json_encode($result);
            return;
        }

        $result['message'] = 'Có lỗi xảy ra!';
        echo json_encode($result);

    }
}