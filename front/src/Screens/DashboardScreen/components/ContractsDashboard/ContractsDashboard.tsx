import React from 'react';

import Card from '../../../../components/Card';
import Loader from '../../../../components/Loader/Loader';

import { useContractsDashboard } from './useContractsDashboard';

const ContractsDashboard = () => {
  const {
    isLoading,
    formattedCards,
  } = useContractsDashboard();

  if (isLoading) return <Loader />;

  return (
    <div className="container contract-dashboard">
      <div className="dashboard-header section-title">Нерухомість</div>

      <div className="grid">
        {formattedCards.map(({ id, title, list, onClick }) => (
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
};

export default ContractsDashboard;
