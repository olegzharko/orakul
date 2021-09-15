import * as React from 'react';
import { Link } from 'react-router-dom';
import Card from '../../../../../../../../../../components/Card';
import Loader from '../../../../../../../../../../components/Loader/Loader';
import { useDashboard } from './useDashboard';

const Dashboard = () => {
  const meta = useDashboard();

  if (meta.isLoading) {
    return (
      <Loader />
    );
  }

  return (
    <div className="side-notaries side-notaries__dashboard">
      <div className="dashboard-header section-title">Сторонній нотаріус</div>

      <div className="grid grid-stretch">
        {meta.notaries.map((notary) => (
          <Card
            key={notary.id}
            title={notary.title}
            onClick={() => meta.onCardClick(`/side-notaries/${meta.id}/${notary.id}`)}
          >
            {notary.list.map((item) => (
              <span>{item}</span>
            ))}
          </Card>
        ))}

        <Link to={`/side-notaries/${meta.id}/create`} className="add-item-card">
          <img src="/images/plus-big.svg" alt="create" />
        </Link>
      </div>
    </div>
  );
};

export default Dashboard;
