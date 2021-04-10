import * as React from 'react';
import { Link } from 'react-router-dom';
import Card from '../../../../../../../../../../components/Card';
import CustomSelect from '../../../../../../../../../../components/CustomSelect';
import Loader from '../../../../../../../../../../components/Loader/Loader';
import PrimaryButton from '../../../../../../../../../../components/PrimaryButton';
import SectionWithTitle from '../../../../../../../../../../components/SectionWithTitle';
import TitleInfoDuet from '../../../../../../../../../../components/TitleInfoDuet';
import { useDashboard } from './useDashboard';

const Dashboard = () => {
  const meta = useDashboard();

  if (meta.isLoading) {
    return (
      <Loader />
    );
  }

  return (
    <div className="seller">
      <div className="dashboard-header section-title">Продавці</div>

      <div className="grid mb50">
        {meta.developers.map(({ color, id, title, info }) => (
          <Card
            key={id}
            title={title}
            link={`/seller/${meta.id}/${id}`}
          >
            {/* {info.list.map((item) => (
              <span>{item}</span>
            ))} */}
          </Card>
        ))}
      </div>

      <SectionWithTitle title="Підписант">
        <div className="seller__signer">
          <CustomSelect
            label="Підписант"
            data={meta.devRepresentative}
            onChange={(e) => meta.setSelectedRepresentative(e)}
            selectedValue={meta.selectedRepresentative}
            className="seller__signer-select"
          />
        </div>

        <div className="seller__signer-title">
          Загальна інформація про підписанта
        </div>

        <div className="grid grid-flex-start">
          {meta.representative.map(({ title, value }) => (
            <TitleInfoDuet key={title} title={title} info={value} />
          ))}
        </div>

        <div className="seller__signer-title">
          Дані про договір доручення (довіреності)
        </div>

        <div className="grid grid-flex-start">
          {meta.representativeDoc.map(({ title, value }) => (
            <TitleInfoDuet key={title} title={title} info={value} />
          ))}
        </div>
      </SectionWithTitle>

      <PrimaryButton
        label="Зберегти"
        onClick={meta.onSave}
        disabled={meta.isSaveButtonDisabled}
        className="seller__ban-button"
      />

    </div>
  );
};

export default Dashboard;
