<?php
include '../includes/connection.php';
session_start();

if (isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];

    // First, get the book_id and member_id associated with the borrowing request
    $sql_get_borrowing_info = "SELECT book_id, member_id FROM borrowing WHERE id = $request_id";
    $result_get_borrowing_info = $conn->query($sql_get_borrowing_info);

    if ($result_get_borrowing_info && $result_get_borrowing_info->num_rows > 0) {
        $row_borrowing_info = $result_get_borrowing_info->fetch_assoc();
        $book_id = $row_borrowing_info['book_id'];
        $member_id = $row_borrowing_info['member_id'];

        // Check if the quantity_available is greater than 0 in the books table
        $sql_check_quantity = "SELECT quantity_available FROM books WHERE book_id = $book_id";
        $result_check_quantity = $conn->query($sql_check_quantity);

        if ($result_check_quantity && $result_check_quantity->num_rows > 0) {
            $row_quantity = $result_check_quantity->fetch_assoc();
            $quantity_available = $row_quantity['quantity_available'];

            if ($quantity_available > 0) {
                $sql_update_borrowing = "UPDATE borrowing SET status = 'approved' WHERE id = $request_id";

                if ($conn->query($sql_update_borrowing) === TRUE) {
                    date_default_timezone_set('Asia/Kathmandu');
                    $issue_date_npt = date('Y-m-d H:i:s');
                    $due_date_npt = date('Y-m-d H:i:s', strtotime($issue_date_npt . ' +30 days'));

                    // Insert the record into the issue table
                    $sql_issue = "INSERT INTO issue (book_id, member_id, issue_date, status, duedate, borrowing_id)
                                  VALUES ($book_id, $member_id, '$issue_date_npt', 'issued', '$due_date_npt', $request_id)";

                    if ($conn->query($sql_issue) === TRUE) {
                        // After inserting into issue table, update the books table to decrement quantity_available by 1
                        $sql_update_quantity = "UPDATE books SET quantity_available = quantity_available - 1 WHERE book_id = $book_id";
                        if ($conn->query($sql_update_quantity) === TRUE) {
                            header('location:requested_book.php');
                            exit();
                        } else {
                            echo "Error updating quantity_available in books table: " . $conn->error;
                        }
                    } else {
                        echo "Error inserting record into issue table: " . $conn->error;
                    }
                } else {
                    echo "Error updating borrowing status to 'approved': " . $conn->error;
                }
            } else {
                // Quantity not available, set session message and redirect
                $_SESSION['message'] = 'The book is currently not available in stock.';
                header('location:requested_book.php');
                exit();
            }
        } else {
            echo "Error fetching quantity from books table: " . $conn->error;
        }
    } else {
        echo "Error fetching book_id and member_id from borrowing table: " . $conn->error;
    }
} else {
    echo "Request ID not provided.";
}
?>
