import styled from 'styled-components';
import { responsive } from '@theme/mixins';
import { primary, secondary, grey, common } from '@theme/palette';
import { weight, size, fontFamily } from '@theme/typography';

const Header = styled.div`
  background: ${common.black};
  color: ${common.white};
  display: flex;
  justify-content: space-between;
  padding: 1rem 1.5rem;
`;

const Sitename = styled.h1`
  font-size: ${size.xlarge};
`;

export default { Header, Sitename };
