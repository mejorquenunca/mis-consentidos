export default function Home() {
  return null;
}

export async function getStaticProps() {
  return {
    redirect: {
      destination: '/index.html',
      permanent: false,
    },
  };
}
