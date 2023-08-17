<?php

namespace App;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Emailer {

  private MailerInterface $mailer;

  private LoggerInterface $logger;

  public function __construct(MailerInterface $mailer, LoggerInterface $logger) {
    $this->mailer = $mailer;
    $this->logger = $logger;
  }

  public function sendEmail(string $subject, string $recipient, string $message, array $attachments = []): void {
    $email = (new Email())
      ->subject($subject)
      ->to($recipient)
      ->html($message);

    foreach ($attachments as $attachment) {
      $email->attachFromPath($attachment);
    }

    try {
      $this->mailer->send($email);
      $this->logEmail('sent', $recipient, $subject, $message, $attachments);
    }
    catch (\Throwable $e) {
      // Handle email sending failure if needed
      $this->logger->error('Email sending failed: ' . $e->getMessage());
    }
  }

  private function logEmail(string $status, string $recipients, string $subject, string $message, array $attachments = []): void {

    $log_info = [
      'status' => $status,
      'recipients' => $recipients,
      'subject' => $subject,
      'message' => $message,
      'attachments' => $attachments,
      ];
    $db = Database::getConnection();
    $db->query("INSERT INTO email_logs (status, recipients, subject, message, attachments, created_at)
                VALUES (:status, :recipients, :subject, :message, :attachments, NOW())", $log_info);

  }

}
