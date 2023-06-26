<?php
require_once "BaseDao.php";

class MidtermDao extends BaseDao {

    public function __construct(){
        parent::__construct();
    }

    /** TODO
    * Implement DAO method used add new investor to investor table and cap-table
    */
    public function investor(){

    }

    /** TODO
    * Implement DAO method to validate email format and check if email exists
    */
    public function investor_email($email){
        $stmt = $this->conn->prepare(
                                    "SELECT * FROM investors WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /** TODO
    * Implement DAO method to return list of investors according to instruction in MidtermRoutes.php
    */
    public function investors($share_class_id){
        $stmt = $this->conn->prepare(
                                    "SELECT sc.description, sc.equity_main_currency, sc.price, sc.authorized_assets,
                                    i.first_name, i.last_name, i.email, i.company, ct.diluted_shares as total_diluted_assets
                                    FROM investors i
                                    JOIN cap_table ct ON i.id = ct.investor_id
                                    JOIN share_class_categories scc ON ct.share_class_category_id = scc.id
                                    JOIN share_classes sc ON scc.share_class_id = sc.id
                                    WHERE sc.id = :share_class_id");
        $stmt->execute(['share_class_id' => $share_class_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
