import * as React from 'react';

import Card from '../../../../../../../../../../../../../components/Card';
import Loader from '../../../../../../../../../../../../../components/Loader/Loader';
import routes from '../../../../../../../../../../../../../routes';

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
        {(meta.immovables || []).map((immovable: any) => (
          <Card
            key={immovable.id}
            title={immovable.title}
            onClick={
              () => meta.onCardClick(
                routes.factory.lines.immovable.sections.immovables.immovableView.linkTo(
                  meta.lineItemId, immovable.id
                )
              )
            }
          >
            {immovable.list.map((item: any) => (
              <span>{item}</span>
            ))}
          </Card>
        ))}
      </div>
    </div>
  );
};

export default Dashboard;
