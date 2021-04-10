import * as React from 'react';
import { Link } from 'react-router-dom';
import CardWithClose from '../../../../../../../../../../components/CardWithClose';
import ConfirmDialog from '../../../../../../../../../../components/ConfirmDialog';
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
    <div className="side-notaries">
      <div className="dashboard-header section-title">Сторонній нотаріус</div>

      <div className="grid">
        {meta.notaries.map((notary) => (
          <CardWithClose
            key={notary.id}
            title={notary.title}
            onClick={() => meta.onModalShow(notary.id.toString())}
            link={`/side-notaries/${meta.id}/${notary.id}`}
          >
            {notary.list.map((item) => (
              <span>{item}</span>
            ))}
          </CardWithClose>
        ))}

        <Link to={`/side-notaries/${meta.id}/create`} className="add-item-card">
          <img src="/icons/plus-big.svg" alt="create" />
        </Link>
      </div>

      <ConfirmDialog
        open={meta.showModal}
        title="Видалення нотаріуса"
        message="Ви впевнені, що бажаєте видалити даного нотаріуса"
        handleClose={() => meta.onModalCancel()}
        handleConfirm={() => meta.onModalConfirm()}
      />
    </div>
  );
};

export default Dashboard;
