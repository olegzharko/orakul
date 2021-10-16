import React from 'react';

import { ClientSideRoomPayment } from '../../types';

type ClientSideRoomPaymentsProps = {
  payments?: ClientSideRoomPayment
}

const ClientSideRoomPayments = ({ payments }: ClientSideRoomPaymentsProps) => {
  if (!payments) return null;

  return (
    <div className="payments">
      <div className="title">
        <img src="/images/credit-card.svg" alt="credit-card" />
        <span>Оплати:</span>
      </div>

      <div className="payments__list">
        {payments?.service_list?.map(({ title, value }) => (
          <span className="payments__part" key={title}>
            {title}
            {' '}
            -
            <b>
              {value}
              {' '}
              грн
            </b>
          </span>
        ))}
      </div>

      <span className="payments__total">
        {payments.total_price.title}
        <b>{payments.total_price.value}</b>
      </span>

      <span className="payments__status">
        {payments.status.title}
        <b>{payments.status.value}</b>
      </span>
    </div>
  );
};

export default ClientSideRoomPayments;
