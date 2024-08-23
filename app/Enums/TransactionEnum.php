<?php

namespace App\Enums;

enum TransactionEnum: string
{
    case quotation = 'QO';
    case tmpDeliveryNote = 'TDN';
    case invoice = 'IV';
    case ivTaxInvoice = 'IVT';
    case deliveryNote = 'DN';
    case receipt = 'RE';
    case rtTaxInvoice = 'RT';
    case saleTaxInvice = 'TIV';
    case creditNote = 'CN';
    case cnTaxInvoice = 'CNT';
    case billingNote = 'BN';
    case debitNote = 'DBN';
    case dnTaxInvoice = 'DBNT';
    case purchaseOrder = 'PO';
    case purchaseInvoice = 'PI';
    case poAsset = 'POA';
    case purchaseRequest = 'PR';
    case expense = 'EXP';
    case receiveCN = 'CNX';
    case comPaymentNote = 'CPN';
    case purchaseAsset = 'PA';
}