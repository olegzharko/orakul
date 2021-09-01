import React from 'react';

const ClientSideRoomPayments = () => (
  <div className="payments">
    <div className="title">
      <img src="/images/credit-card.svg" alt="credit-card" />
      <span>Оплати:</span>
    </div>

    <div className="payments__list">
      <span className="payments__part">
        Основний договір -
        <b>18 000 грн</b>
      </span>
      <span className="payments__part">
        Попередній договір -
        <b>22 000 грн</b>
      </span>
      <span className="payments__part">
        Довіреність -
        <b>безкоштовно</b>
      </span>
    </div>

    <span className="payments__total">
      Всього:
      <b>40 000 грн</b>
    </span>

    <span className="payments__status payments__status-success">
      Статус:
      <b>розраховано</b>
    </span>
  </div>
);

export default ClientSideRoomPayments;
