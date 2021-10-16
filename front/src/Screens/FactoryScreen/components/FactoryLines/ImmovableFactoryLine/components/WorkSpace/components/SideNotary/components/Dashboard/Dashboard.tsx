import * as React from 'react';
import { Link } from 'react-router-dom';

import Card from '../../../../../../../../../../../components/Card';
import Loader from '../../../../../../../../../../../components/Loader/Loader';
import routes from '../../../../../../../../../../../routes';

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
            onClick={
              () => meta.onCardClick(
                routes.factory.lines.immovable.sections.sideNotaries.view.linkTo(
                  meta.lineItemId, notary.id
                )
              )
            }
          >
            {notary.list.map((item) => (
              <span>{item}</span>
            ))}
          </Card>
        ))}

        <Link
          to={routes.factory.lines.immovable.sections.sideNotaries.create.linkTo(meta.lineItemId)}
          className="add-item-card"
        >
          <img src="/images/plus-big.svg" alt="create" />
        </Link>
      </div>
    </div>
  );
};

export default Dashboard;
