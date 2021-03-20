import * as React from 'react';
import './index.scss';

const data = [
  {
    key: 0,
    title: 'Усі',
    quantity: 50,
  },
  {
    key: 1,
    title: 'Готові',
    quantity: 10,
  },
  {
    key: 2,
    title: 'Основних',
    quantity: 30,
  },
  {
    key: 3,
    title: 'Попередніх',
    quantity: 4,
  },
  {
    key: 4,
    title: 'Скасовано',
    quantity: 2,
  },
];

const Contracts = () => (
  <div className="dashboard__filter-contracts">
    <span className="title">Договори</span>
    <div className="cards">
      {data.map((item: any) => (
        <div className="item">
          <div className="item__left">
            <img src="/icons/contract.svg" alt="contract" />
            <span className="name">{item.title}</span>
          </div>
          <span className="quantity">{item.quantity}</span>
        </div>
      ))}
    </div>
  </div>
);

export default Contracts;
