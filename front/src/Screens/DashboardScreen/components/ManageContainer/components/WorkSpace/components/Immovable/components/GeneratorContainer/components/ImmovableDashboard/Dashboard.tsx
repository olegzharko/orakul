import * as React from 'react';
import Card from '../../../../../../../../../../../../components/Card';
import Loader from '../../../../../../../../../../../../components/Loader/Loader';
import { useDashboard } from './useDashboard';

const Dashboard = () => {
  const meta = useDashboard();

  if (meta.isLoading) {
    return (
      <Loader />
    );
  }

  return (
    <div className="immovable__dashboard">
      <div className="dashboard-header section-title">Нерухомість</div>

      <div className="grid">
        {(meta.immovables || []).map((immovable) => (
          <Card
            key={immovable.id}
            title={immovable.title}
            link={`/immovables/${meta.id}/${immovable.id}`}
          >
            {immovable.list.map((item) => (
              <span>{item}</span>
            ))}
          </Card>
        ))}
      </div>
    </div>
  );
};

export default Dashboard;
