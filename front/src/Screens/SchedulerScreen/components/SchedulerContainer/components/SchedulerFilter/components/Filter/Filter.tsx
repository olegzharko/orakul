import React from 'react';
import CustomSelect from '../../../../../../../../components/CustomSelect';
import { useFilter } from './useFilter';
import Loader from '../../../../../../../../components/Loader/Loader';

const Filter = () => {
  const meta = useFilter();

  if (!meta.shouldRenderFilter) {
    return null;
  }

  return (
    <div className="filter">
      <span style={{ whiteSpace: 'nowrap' }}>Сортувати по:</span>
      <div className="mh6 filter__select" style={{ width: '115px' }}>
        <CustomSelect
          data={meta.notaries}
          onChange={meta.setSelectedNotary}
          label="Нотаріус"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '90px' }}>
        <CustomSelect
          data={meta.readers}
          onChange={meta.setSelectedReader}
          label="Читач"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '110px' }}>
        <CustomSelect
          data={meta.accompanyings}
          onChange={meta.setSelectedAccompanying}
          label="Видавач"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '150px' }}>
        <CustomSelect
          data={[]}
          onChange={meta.setSelectedContractType}
          label="Тип договору"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '140px' }}>
        <CustomSelect
          data={meta.developers}
          onChange={meta.setSelectedDeveloper}
          label="Забудовник"
          size="small"
        />
      </div>

      <div className="mh6 filter__select" style={{ width: '125px' }}>
        <CustomSelect
          data={meta.representative}
          onChange={meta.setSelectedRepresentative}
          label="Підписант"
          size="small"
        />
      </div>
    </div>
  );
};

export default Filter;
