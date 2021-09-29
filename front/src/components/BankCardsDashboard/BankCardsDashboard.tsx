import React from 'react';

import Loader from '../Loader/Loader';

import './index.scss';
import { useBankCardsDashboard } from './useBankCardsDashboard';

const BankCardsDashboard = () => {
  const { isLoading, cards } = useBankCardsDashboard();

  if (isLoading) return <Loader />;

  if (!cards) return null;

  return (
    <div className="vision-bank">
      {cards.map(({ title, info }) => (
        <div className="bank-card" key={title}>
          <div className="bank-card__title">
            <img src="/images/clock.svg" alt="clock" />
            <span>{title}</span>
          </div>
          <div className="bank-card__info">
            {info.map((link) => (
              <a key={link.id} href={`/${link.link}`}>{link.title}</a>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
};

export default BankCardsDashboard;
