import * as React from 'react';
import { Link } from 'react-router-dom';

import CardWithClose from '../../../../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../../../../components/ConfirmDialog';
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
        {meta.mappedImmovables.map((immovable: any) => (
          <CardWithClose
            key={immovable.id}
            title={immovable.title}
            onRemove={immovable.onRemove}
            onClick={immovable.onClick}
          >
            {immovable.list.map((item: any) => (
              <span>{item}</span>
            ))}
          </CardWithClose>
        ))}

        <Link to={routes.factory.lines.immovable.sections.immovables.immovableCreate.linkTo(meta.lineItemId)} className="add-item-card">
          <img src="/images/plus-big.svg" alt="create" />
        </Link>
      </div>

      <ConfirmDialog
        open={meta.showModal}
        title="Видалення нерухомості"
        message="Ви впевнені, що бажаєте видалити дану нерухомість?"
        handleClose={() => meta.onModalCancel()}
        handleConfirm={() => meta.onModalConfirm()}
      />
    </div>
  );
};

export default Dashboard;
