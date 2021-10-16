import React from 'react';

import Card from '../../../../../../components/Card';

type ContractMainCard = {
  id: number;
  list: string[];
  title: string;
  onClick: () => void
}

type ContractMainDashboardProps = {
  title: string;
  cards: ContractMainCard[];
}

const ContractMainDashboard = ({ title, cards }: ContractMainDashboardProps) => (
  <div className="container contract-dashboard">
    <div className="dashboard-header section-title">{title}</div>

    <div className="grid">
      {cards.map(({ id, title, list, onClick }) => (
        <Card
          key={id}
          title={title}
          onClick={onClick}
        >
          {list.map((info) => (
            <span key={info}>{info}</span>
          ))}
        </Card>
      ))}
    </div>
  </div>
);

export default ContractMainDashboard;
