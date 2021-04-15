import * as React from 'react';
import { Link } from 'react-router-dom';
import CardWithClose from '../../../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../../../components/ConfirmDialog';
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
        {meta.immovables.map((immovable) => (
          <CardWithClose
            key={immovable.id}
            title={immovable.title}
            onClick={() => meta.onModalShow(immovable.id.toString())}
            link={`/immovables/${meta.id}/${immovable.id}`}
          >
            {immovable.list.map((item) => (
              <span>{item}</span>
            ))}
          </CardWithClose>
        ))}

        <Link to={`/immovables/${meta.id}/create`} className="add-item-card">
          <img src="/icons/plus-big.svg" alt="create" />
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
